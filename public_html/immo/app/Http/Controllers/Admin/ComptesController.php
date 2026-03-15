<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Pays;
use App\Models\Compte;
use App\Models\Devise;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ComptesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $comptes = Compte::with('devise')->get();
        return view('admin.comptes.index',compact('comptes'));
    }
    public function liste()
    {
        //
        $comptes = Compte::with('devise')->get();
        return view('admin.comptes.liste',compact('comptes'));
    }
    public function statistiques($id,$current_year=null)
    {
        //
        $compte = Compte::find($id);
        $devises = Devise::all();
        $pays = Pays::getListe();
        if($current_year){
            $today  =   Carbon::create($current_year.'-'.now()->format('m'));
            $year   =   $current_year;
        }else{
            $today  =   now();
            $year   =   $today->year;
        }
        $datas = $compte::arrayStatDashboard($compte);
        $commandes_validees = $compte->commandes_validees()->whereYear('commande_date',$today->year)->whereMonth('commande_date',$today->month)->count();
        $commandes_confirmees = $compte->commandes_confirmees()->whereYear('commande_date',$today->year)->whereMonth('commande_date',$today->month)->count();
        $commandes_traitees = $compte->commandes_traitees()->whereYear('commande_date',$today->year)->whereMonth('commande_date',$today->month)->count();
        $commandes_brouillons = $compte->commandes_brouillons()->whereYear('commande_date',$today->year)->whereMonth('commande_date',$today->month)->count();
        $commandes_en_retard = $compte->commandes_en_retard()->whereYear('commande_date',$today->year)->whereMonth('commande_date',$today->month)->count();
        $commandes_annulees = $compte->commandes_annulees()->whereYear('commande_date',$today->year)->whereMonth('commande_date',$today->month)->count();
        $commandes = $compte::arrayMoisEnCours($compte,$today,$year,$commandes_validees,$commandes_confirmees,$commandes_traitees,$commandes_brouillons,$commandes_annulees);
        $date = $today;
        $mois_precedent = $date->subMonth()->format('m');

        $commandes_annulees_mois_precedent = $compte->commandes_annulees()->whereYear('commande_date',$today->year)->whereMonth('commande_date',$mois_precedent)->get();

        $mois_precedent = $compte::arrayMoisPrecedent($compte,$date->year,$date,$mois_precedent,$commandes_annulees_mois_precedent->count());
        $today->addMonth();

        return view('admin.comptes.statistiques',compact('compte','devises','pays','datas','commandes','mois_precedent','today'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $compte = new Compte();
        $devises = Devise::all();
        $pays = Pays::getListe();
        return view('admin.comptes.create',compact('compte','devises','pays'));

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
        $data = request()->all();

        $validate = request()->validate([
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed',//|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[@#$%^&+=_!?,;-])(?=.*[A-Z])[0-9a-zA-Z!@#\$%\^\&*\)\(@#$%^&+=_!?,;-]{8,}$/|min:8',
			'compte.libelle' => 'required|max:255',
			'compte.devise_id' => 'required',
			'compte.adresse' => 'required',
            'compte.validation_manager'=>'required',
			'compte.telephone' => 'required',
        ]);

        $data_compte = $data['compte'];
        unset($data['compte']);
        unset($data['password_confirmation']);
        $data_compte['email']=$data['email'];
        $compte = new Compte($data_compte);
        if($compte = $compte->create($data_compte)){
            $user = new User();
            $data['compte_id'] = $compte->id;
            $data['password'] = Hash::make($data['password']);
            $data['username'] = $data['email'];
            $data['profil'] = 'admin';
            // dd($data);
            if($user->create($data)){
                return redirect()->route('admin.comptes.index')->withSuccess("L'opération a été enregistrée avec succès!");
            }
            return redirect()->back()->withErrors("L'opération a échoué !");
        }
        return redirect()->back()->withErrors("L'opération a échoué !");
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
        $compte = Compte::find($id);
        $devises = Devise::all();
        $pays = Pays::getListe();
        return view('admin.comptes.show',compact('compte','devises','pays'));

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
        $devises = Devise::all();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $compte = Compte::findOrFail($id);
        // $compte->devise->conversion = request('compte.conversion');
        return $compte->update(request('compte'))
        ? redirect()->route('admin.comptes.show',$compte->id)->withSuccess("L'opération a été effectuée avec succès !")
        : redirect()->back()->withErrors("L'opération a échoué !");
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
        $compte = Compte::findOrFail($id);

        if($compte){
            $compte->status = $compte->status == 1 ? 0 : 1;
            $compte->save();
            $compte->users()->update(['statut'=>$compte->status]);
            return back()->withErrors("L'opération a réussi!");
        }
		return back()->withErrors("L'opération a échoué !");
    }
}
