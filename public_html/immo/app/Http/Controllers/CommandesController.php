<?php

namespace App\Http\Controllers;

use App\Events\MailEvent;
use App\Exports\CommandesExport;
use App\Models\Commande;
use App\Models\CommandeLigne;
use App\Models\Fournisseur;
use App\Models\Produit;
use App\Models\Reception;
use App\Models\ReceptionLigne;
use App\Models\Station;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
class CommandesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $commande = new Commande();
        // $this->authorizeResource(Commande::class, 'commande',['view']);
    }
    public function brouillons()
    {
        //
        $commandes = Commande::enBrouillons()->limit(10)->latest()->get();
        $titre = "Les commandes en brouillons";
        return view('commandes.index',compact('commandes','titre'));
    }

    public function enAttentes(){
        $commandes = Commande::enAttentes()->get();
        $titre = "Les commandes en attentes";
        return view('commandes.index',compact('commandes','titre'));
    }
    public function confirmees(){
        $commandes = Commande::confirmes()->latest()->limit(10)->orderBy('id','DESC')->get();
       // dd( $commandes);
        $titre = "Les commandes confirmées";
        $etat = 'confirmé';

        return view('commandes.index',compact('commandes','titre','etat'));
    }

    public function traitees(){
        // $commandes = Commande::traites()->latest()->limit(5)->get();
       // dd( $commandes);
        $titre = "Les commandes traitées";
        $etat = 'traité';
        $filtre = true;

        return view('commandes.index',compact('filtre','titre','etat','filtre'));
    }
    public function validees(){
        $confirmes =  Commande::whereIn('etat',['confirmé'])->whereYear('commande_date',now()->year)->get();
        $encours =  Commande::whereIn('etat',['validé'])->whereYear('commande_date',now()->year)->get();
        $titre = "Les commandes validées";
        $filtre = true;
        $card = true;
        $etat = 'validé';
        return view('commandes.index',compact('titre','filtre','etat','encours','confirmes','card'));
    }
    public function getCommandes(Request $request,$etat = null)
    {
        $data =  Commande::traites()->whereYear('commande_date',now()->year)->get();

        if ($etat == 'validé') {
            if (in_array(Auth::user()->profil ,['gerant','fournisseur'])) {
                $data =  Commande::whereIn('etat',['validé'])->whereYear('commande_date',now()->year)->get();
            }else{
                $data =  Commande::whereIn('etat',['confirmé','validé'])->whereYear('commande_date',now()->year)->get();
            }
        }

        return DataTables::of($data)
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('commandes.show',[$row->id]).'" data-id="'.$row->id.'" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>';
                    return $btn;
                })
                ->addColumn('ref', function($item) {
                    return $item->ref;
                })
                ->addColumn('fournisseur', function($item) {
                    return $item->fournisseur->nom;
                })
                ->addColumn('station', function($item) {
                    return $item->station->nom;
                })
                ->rawColumns(['action','fournisseur'])
                ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $commande = new Commande();
        $fournisseurs = Fournisseur::all();
        $produits = Produit::all();
        $stations = Station::all();

        $this->authorize('create', $commande);
        return view('commandes.create',compact('commande','fournisseurs','produits','stations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $data = request()->all();
        $commande = new Commande();
        $commande->crea_date = Carbon::now();
        $commande->commande_date = Carbon::now();
        $commande->fournisseur_id = $data['fournisseur_id'];
        $commande->station_id = $data['station_id'];
        $commande->compte_id = Auth::user()->compte_id;
        $commande->etat = "brouillon";
        $commande->remise = 0;
        $commande->tva = $data['total_tva'];
        $commande->montant_ttc = $data['total_ttc'];
        $commande->montant_ht = $data['total_ht'];
        $station = Station::find($data['station_id']);
        $fournisseur = Fournisseur::find($data['fournisseur_id']);
        $desserte = $fournisseur->dessertes()->where('zone_id',$station->zone_id)->first();
        $delai =  $desserte?$desserte->delai:2;
        $commande['livraison_date'] = Carbon::now()->addDay($delai)->format('Y-m-d');
        if($commande->save()){
            foreach ($data['id'] as $key => $value) {
                $line = new CommandeLigne();
                $line->add($data,$key,$value,$commande->id);
            }
            return redirect()->route('commandes.show',$commande->id)->withErrors(__("general.message_success"));
        }
        return redirect()->route('admin.commandes.index')->withErrors(__("general.message_error"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reception($id){
        $commande = Commande::find($id);
        if ($commande->estInComplete()) {
            $commande->updateEtat('confirmé');
        }
        return view('commandes.reception',compact('commande'));
    }
    public function receptionDefinitive($id){
        $commande = Commande::find($id);
        $commande->receptionnerDefinitivement();
        if ($commande->estInComplete()) {
            $commande->updateEtat('confirmé');
        }
        return redirect()->back();
    }
    public function retour($id){
        $commande = Commande::find($id);
        return view('commandes.retour',compact('commande'));
    }
    public function storeReception(Request $request){
        $data = $request->all();
        $is_retour = $data['is_retour']??0;
        $reception = Reception::findOrCreate($data['commande_id'],$is_retour);
        $filePath = 'receptions.xlsx';
        $datas = ($reception->commande->commande_lignes);
        $reception->saveLines($data);
        // $commande = $reception->commande;
        if ($is_retour == 1) {
            return redirect()->route('commandes.reception',$reception->commande->id)->with(__("commande.message_success"));
        }
        return redirect()->back();

    }
    public function show($id){
        $commande = Commande::find($id);
        // $this->authorize('view');

        $this->authorize('view', $commande);
        $titre ='Commande';
        $detail = 'Commande';
        $is_commande = true;
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf.bonReceptionPdf', compact('detail','titre','is_commande','commande'));
        $url = "uploads/commandes/{$commande->ref}.pdf";
        $pdf->save(public_path($url));
        $attachement = public_path($url);
        // event(new MailEvent('commande:gerant', $commande, $attachement));
        return view('commandes.show',compact('commande'));
    }

    public function soumettre($id){
        $commande = Commande::find($id);
        if($commande->compte->as_validation_commande && $commande->etat != 'en attente') $commande->etat = "en attente";
        else  $commande->etat = 'validé';
        if($commande->save()){
            if($commande->compte->as_validation_commande) return redirect()->route('commandes.en_attente')->with(__("commande.message_success"));
            else return redirect()->route('commandes.validees')->with(__("commande.message_success"));
        }
        else return back()->with(__("commande.message_error"));
    }
    public function updateCommande(Request $request,$id){
        $commande = Commande::find($id);
        $commande->etat = request('etat');
        if($commande->save()){
            return redirect()->back()->with(__("commande.message_success"));
        }
        return back()->with(__("commande.message_error"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $commande = Commande::find($id);
        $fournisseurs = Fournisseur::all();
        $commande_lignes = $commande->commande_lignes;
        $produits_cmdes = [];
        foreach($commande->commande_lignes as $commande_ligne){
            $produits_cmdes[] = $commande_ligne->produit;
        }
        $stations = Station::all();
        $produits = Produit::where('fournisseur_id',$commande->fournisseur_id)->get();
        return view('commandes.edit',compact('commande','produits','stations','fournisseurs','commande_lignes','produits_cmdes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $data =  request()->all();
        $commande = Commande::find($id);
        foreach($commande->commande_lignes as $ligne){
            $ligne->delete();
        }
        $commande->tva = $data['total_tva'];
        $commande->montant_ttc = $data['total_ttc'];
        $commande->montant_ht = $data['total_ht'];
        if($commande->save()){
            foreach ($data['id'] as $key => $value) {
                $line = new CommandeLigne();
                $line->add($data,$key,$value,$id);
            }
        }
        return redirect()->route('commandes.show',$commande->id)->withErrors(__("general.message_success"));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $commande = Commande::find($id);
        $commande->etat= 'supprimé';
        if($commande->update()) {
            Session::flash('success', __('commande.success_delete'));
        } else {
            Session::flash('error', __('commande.error_delete'));
        }
        return back();
    }

    public function listeReceptions($id){
        $reception = Reception::where('id',$id)->with('reception_lignes.commande_ligne.produit')->first();
        return response()->json($reception->reception_lignes);

    }
    public function pdf($id)
    {
        //
        $commande = Commande::find($id);
        $pdf = App::make('dompdf.wrapper');
        $titre ='Commande';
        $detail = 'Commande';
        $is_commande = true;
        $pdf->loadView('pdf.bonReceptionPdf', compact('detail','titre','is_commande','commande'));
        return $pdf->stream();
    }
    public function clone($id)
    {
        //
        $commande = Commande::find($id);
        if($commande->clone()){
            return redirect()->route('commandes.brouillons')->with(__("commande.message_success"));
        }
        return redirect()->route('commandes.brouillons')()->with(__("commande.message_error"));
    }
}
