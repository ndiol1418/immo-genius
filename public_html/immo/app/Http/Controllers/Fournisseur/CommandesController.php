<?php

namespace App\Http\Controllers\Fournisseur;

use App\Http\Controllers\Controller;
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

class CommandesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function brouillons()
    {
        //
        $commandes = Commande::enBrouillons()->limit(10)->latest()->get();
        $titre = "Les commandes en brouillons";
        return view('commandes.index',compact('commandes','titre'));
    }

    public function enAttentes(){
        $commandes = Commande::enAttentes()->get();
       // dd( $commandes);
        $titre = "Les commandes en attentes";
        return view('commandes.index',compact('commandes','titre'));
    }
    public function confirmees(){
        $commandes = Commande::confirmes()->latest()->limit(10)->orderBy('id','DESC')->get();
    //    dd( $commandes);
        $titre = "Les commandes confirmées";
        return view('commandes.index',compact('commandes','titre'));
    }

    public function traitees(){
        $commandes = Commande::traites()->latest()->limit(5)->get();
       // dd( $commandes);
        $titre = "Les commandes traitées";
        return view('commandes.index',compact('commandes','titre'));
    }
    public function validees(){
        $commandes = Commande::valides()->limit(10)->latest()->get();
       // dd( $commandes);
        $titre = "Les commandes validées";
        return view('commandes.index',compact('commandes','titre'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        $reception->saveLines($data);
        // $commande = $reception->commande;
        if ($is_retour == 1) {
            return redirect()->route('commandes.reception',$reception->commande->id)->with(__("commande.message_success"));
        }
        return redirect()->back();

    }
    public function show($id){
        $commande = Commande::find($id);

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
}
