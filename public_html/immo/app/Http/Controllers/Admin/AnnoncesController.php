<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Bien;
use App\Models\Commune;
use App\Models\Departement;
use App\Models\Immo;
use App\Models\Level;
use App\Models\Piece;
use App\Models\TypeImmo;
use App\Models\TypeLocation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AnnoncesController extends Controller
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
        $title = 'annonces';
        $annonces = Annonce::actif()->get();
        if(isset($_GET['var'])){
            $type = $_GET['var'];
            $annonces = Annonce::where('status',$type)->get();
            $title = $type==1?'Locations':'Ventes';
        }

        // dd('ok');
        // foreach ($annonces as $key => $annonce) {
        //     # code...
        //     if ($annonce->pieces !=null) {
        //         $annonce->chambres = ($annonce->pieces[1]['Chambres']);
        //         $annonce->toillettes = ($annonce->pieces[2]['Toillettes']);
        //         $annonce->cuisines = ($annonce->pieces[3]['Cuisines']);
        //         $annonce->salons = ($annonce->pieces[4]['Salons']);
        //         $annonce->save();
        //     }
        // }
        return view($this->espace.'.annonces.index',compact('annonces','title'));
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
        $pieces = Piece::all();
        $type_locations = TypeLocation::all();
        $levels = Level::all();
        $biens = Bien::all();
        $type_immos = TypeImmo::all();
        $communes = Commune::actif()->get();
        $annonce = new Annonce();
        return view($this->espace.'.immos.create',compact('immo','pieces','biens','levels','type_locations','type_immos','communes','annonce'));
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
        $immo = new Immo();
        $pieces = Piece::all();
        $type_locations = TypeLocation::all();
        $levels = Level::all();
        $biens = Bien::all();
        $type_immos = TypeImmo::all();
        $communes = Commune::actif()->get();
        $departements = Departement::actif()->get();
        $type = 'edit';
        $annonce = Annonce::find($id);
        return view('template.pages.publication',compact('annonce','immo','pieces','biens','levels','type_locations','type_immos','communes','departements'));
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
        $annonce = Annonce::find($id);

        if($annonce->update(['status'=>0])) {
            Session::flash('success', "L'operation a été modifie avec succès.");
        } else {
            Session::flash('error', "La suppression a échoué.");
        }
        return back();
    }

    public function enAttente(){
        $annonces = Annonce::enAttente()->get();
        $titre = 'en attente';
        return view($this->espace.'.annonces.index',compact('annonces','titre'));
    }
    public function supprimes(){
        $annonces = Annonce::supprimes()->get();
        $titre = 'rejetees';
        return view($this->espace.'.annonces.index',compact('annonces','titre'));
    }
    public function valideAnnonce($id){
        $annonce = Annonce::find($id);
        $annonce->update(['status'=>1]);
        Session::flash('success', "L'operation a été supprimé avec succès.");
        return back();
    }
    
}
