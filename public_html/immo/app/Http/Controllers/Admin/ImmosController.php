<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Bien;
use App\Models\Commune;
use App\Models\Comodite;
use App\Models\Departement;
use App\Models\Fournisseur;
use App\Models\Immo;
use App\Models\Level;
use App\Models\Piece;
use App\Models\TypeImmo;
use App\Models\Region;
use App\Models\TypeLocation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ImmosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $espace;
    public function __construct(User $user)
    {
        $this->espace = !$user->fournisseur?'admin':'agent';
    }
    public function index()
    {
        //
        $immos = Immo::actif()->get();
        return view($this->espace.'.immos.index',compact('immos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $immo = new Immo();
        if(isset($_GET['immo'])){
            $immo = Immo::find($_GET['immo']);
            if(!$immo){
                $immo = new Immo();
            }else{
                return redirect()->route($this->espace.'.immos.edit',$immo->id);
            }
        }
        $pieces = Piece::all();
        $type_locations = TypeLocation::all();
        $levels = Level::all();
        $biens = Bien::all();
        $type_immos = TypeImmo::all();
        $communes = Commune::actif()->get();
        $departements = Departement::actif()->get();
        $comodites = Comodite::all();
        $regions = Region::with(['departements' => function($q) {
            $q->actif()->with(['communes' => function($q2) { $q2->actif(); }]);
        }])->where('status', 1)->get();
        return view($this->espace.'.immos.create',compact('immo','pieces','biens','levels','type_locations','type_immos','communes','departements','comodites','regions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $data = $request->all();
        $request->validate([
            'immo.name'=>'required|max:255',
            'immo.montant'=>'required',
            'immo.type_immo_id'=>'required|exists:type_immos,id',
        ]);
        if (Auth::user()->fournisseur) {
            $data['immo']['fournisseur_id']= Auth::user()->fournisseur->id;
        }
        $data['immo']['type_location_id'] = request('type_location_id');
        if (Auth::user()->fournisseur) {
            $data['fournisseur_id'] = Auth::user()->fournisseur->id;
        }
        DB::beginTransaction();
        if($immo = Immo::create($data['immo'])){
            $name = $data['immo']['name'];
            unset($data['immo']);
            $annonce = new Annonce();
            $annonce->pieces = $data['pieces'];
            $annonce->comodites = $data['comodites'];
            $annonce->meubles = $data['meubles'];
            $annonce->superficie = $data['superficie'];
            $annonce->description = request('description');
            $annonce->status = 2;
            $annonce->immo_id = $immo->id;
            $annonce->prix = $immo->montant;
            $annonce->name = $immo->name;
            $annonce->type_immo_id = $immo->type_immo_id;
            $annonce->commune_id = $immo->bien?$immo->bien->commune_id:null;
            $annonce->departement_id = $immo->bien&&$immo->commune?$immo->commune->departement_id:null;
            $annonce->slug = Str::slug($name.$immo->id);
            $annonce->is_premium = $data['is_premium'];
            $annonce->superficie = request('superficie');
            $annonce->chambres = request('pieces')[1]['Chambres'];
            $annonce->toillettes = request('pieces')[3]['Toilettes'];
            $annonce->cuisines = request('pieces')[4]['Cuisines'];
            $annonce->salons = request('pieces')[2]['Salons'];
            if (Auth::user()->fournisseur && Auth::user()->fournisseur->is_premium) {
                $annonce->is_premium = 1;
            }
            try {
                // dd($annonce);

                if($annonce->save()){
                    if(count($data['images']) > 0) $annonce->savePJ($data['images'],'App\Models\Annonce');
                }
                DB::commit();
                //code...
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
            }
        }
        Session::flash('success', __('general.success'));

        return redirect()->route($this->espace.'.immos.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $immo = Immo::find($id);
        // dd($immo->fournisseur->agents);
        $ids = $immo->fournisseur && $immo->fournisseur->agents!=null?$immo->fournisseur->agents->toArray():[];
        $mes_agents = Fournisseur::whereIn('id',$ids)->get();
        $agents = Fournisseur::whereNotIn('id',$ids)->get();
        return view($this->espace.'.immos.show',compact('immo','agents','mes_agents'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $immo = Immo::find($id);
        $pieces = Piece::all();
        $type_locations = TypeLocation::all();
        $levels = Level::all();
        $biens = Bien::all();
        $type_immos = TypeImmo::all();
        $communes = Commune::actif()->get();
        return view($this->espace.'.immos.edit',compact('immo','pieces','biens','levels','type_locations','type_immos','communes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $immo = Immo::find($id);
        $data = $request->all();
        if ($request->has('affectation')) {
            if($immo->update(['agent_id'=>request('fournisseur_id')])){
                Session::flash('success', "L'opération a été effectuée.");
            }else {
                Session::flash('error', "L'opération a échoué.");
            }
            return redirect()->back();
        }else{

        $request->validate([
            'immo.name'=>'required|max:255',
            'immo.montant'=>'required',
            'immo.type_immo_id'=>'required|exists:type_immos,id',
        ]);
        }
        if($immo->update($data)){
            Session::flash('success', "L'opération a été effectuée.");
        }else {
            Session::flash('error', "L'opération a échoué.");
        }
        return redirect()->back();
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
        $immo = Immo::find($id);
        if($immo->update(['status'=>0])) {
            Session::flash('success', "L'annonce a été supprimée avec succès!");
        } else {
            Session::flash('error', "Echec de la suppression!");
        }

        return back();
    }
}
