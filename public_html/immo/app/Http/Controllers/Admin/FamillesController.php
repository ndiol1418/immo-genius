<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Compte;
use App\Models\Famille;
use Illuminate\Http\Request;
use App\Http\Custom\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FamillesController extends Controller
{
    public function index(){
        $familles = Famille::where('statut',1)->get();
        $famille = new Famille();
        $comptes = Compte::where('status',1)->get();
        return view('admin.familles.index',compact('familles','famille','comptes'));
    }

    public function store(Request $request){
        $validate = $request->validate([
            'libelle'=>'unique:familles|required|max:255',
            'compte_id'=>'',
            'statut'=>''
        ]);
        $famille = Famille::create($validate);
        Log::ACTION_GENEGAL("Création famille", "L'admnistrateur " . Auth::user()->nom_complet . " a créé la famille : $famille->libelle.");
        Session::flash('success', __('famille.add_fam'));
        return redirect('admin/familles');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Famille  $famille
     * @return \Illuminate\Http\Response
     */
    public function show(Famille $famille){
        $famille = $famille;
        return view('admin.familles.show',compact('famille'));
    }

    public function create(){
        $famille = new Famille();
        $comptes = Compte::where('status',1)->get();
        return view('admin.familles.create', compact('famille','comptes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Famille  $famille
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $famille = Famille::find($id);
        $comptes = Compte::all();
        return view('admin.familles.edit', compact('famille','comptes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Famille  $famille
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Famille $famille){
        $validate = $request->validate([
            'libelle'=>'unique:familles,libelle,' . $famille->id . '|required|max:255',
            'compte_id'=>'',
            'statut'=>''
        ]);
        $famille->update($validate);
        Log::ACTION_GENEGAL("Mise à jour famille", "L'admnistrateur " . Auth::user()->nom_complet . " a modifié la famille : $famille->name.");
        Session::flash('success', __('famille.update_fam'));
        return redirect('/admin/familles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Famille  $famille
     * @return \Illuminate\Http\Response
     */
    public function destroy(Famille $famille){
        $famille->statut= 0;
        if($famille->update()) {
            Session::flash('success', __('famille.success_delete'));
        } else {
            Session::flash('error', __('famille.error_delete'));
        }
        return back();
    }
}
