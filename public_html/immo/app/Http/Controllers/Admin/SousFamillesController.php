<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Custom\Log;
use App\Models\Compte;
use App\Models\Famille;
use App\Models\SousFamille;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SousFamillesController extends Controller
{
    public function index()
    {
        $sous_familles = SousFamille::where('statut',1)->get();
        $sous_famille = new SousFamille();
        $familles = Famille::where('statut',1)->get();
        $comptes = Compte::where('status',1)->get();
        return view('admin.sous_familles.index',compact('sous_familles','sous_famille','familles','comptes'));
    }

    public function store(Request $request){
        $validate = $request->validate([
            'libelle'=>'unique:sous_familles|required|max:255',
            'famille_id'=>'',
            'compte_id'=>'',
            'statut'=>''
        ]);
        $sous_famille = SousFamille::create($validate);
        Log::ACTION_GENEGAL("Création sous famille produit", "L'admnistrateur " . Auth::user()->nom_complet . " a créé la sous-famille : $sous_famille->libelle.");
        Session::flash('success',__('sous-famille.add_fam'));
        return redirect('admin/sous-familles');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Famille  $famille
     * @return \Illuminate\Http\Response
     */
    public function show(SousFamille $sous_famille){
        $sous_famille = $sous_famille;
        return view('admin.sous_familles.show',compact('sous_famille'));

    }

    public function create()
    {
        $sous_famille = new SousFamille();
        $familles = Famille::where('statut',1)->get();
        return view('admin.sous_familles.create', compact('sous_famille','familles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Famille  $famille
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $sous_famille = SousFamille::find($id);
        $familles = Famille::where('statut',1)->get();
        return view('admin.sous_familles.edit', compact('sous_famille','familles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Famille  $famille
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SousFamille $sous_famille){
        $validate = $request->validate([
            'libelle'=>'unique:sous_familles,libelle,' . $sous_famille->id . '|required|max:255',
            'compte_id'=>'',
            'statut'=>''
        ]);

        $sous_famille->update($validate);

        Log::ACTION_GENEGAL("Mise à jour sous-famille", "L'admnistrateur " . Auth::user()->nom_complet . " a modifié la sous-famille : $sous_famille->name.");

        Session::flash('success', __('sous-famille.update_fam'));

        return redirect('/admin/sous-familles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Famille  $famille
     * @return \Illuminate\Http\Response
     */
    public function destroy(SousFamille $sous_famille)
    {
        $sous_famille->statut= 0;
        if($sous_famille->update()) {
            Session::flash('success', __('sous-famille.success_delete'));
        } else {
            Session::flash('error', __('sous-famille.error_delete'));
        }

        return back();
    }
}
