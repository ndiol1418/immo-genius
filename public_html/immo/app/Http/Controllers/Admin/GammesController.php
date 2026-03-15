<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Custom\Log;
use App\Models\Compte;
use App\Models\Gamme;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GammesController extends Controller
{
    public function index()
    {
        $gammes = Gamme::Actif()->get();
        $gamme = new Gamme();
        $comptes = Compte::where('status',1)->get();
        return view('admin.gammes.index',compact('gammes','gamme','comptes'));
    }

    public function store(Request $request){
        $validate = $request->validate([
            'nom'=>'unique:gammes|required|max:255',
            'compte_id'=>'',
            'rang'=>''
        ]);
       // dd( $validate);
        $gamme = Gamme::create($validate);
        Log::ACTION_GENEGAL("Création gamme produit", "L'admnistrateur " . Auth::user()->nom_complet . " a créé la gamme : $gamme->nom.");
        Session::flash('success', __('gamme.add_gam'));
        return redirect('admin/gammes');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Famille  $famille
     * @return \Illuminate\Http\Response
     */
    public function show(Gamme $gamme){

        return view('admin.gammes.show',compact('gamme'));

    }

    public function create()
    {
        $gamme = new Gamme();
        $comptes = Compte::where('status',1)->get();
        return view('admin.gammes.create', compact('gamme','comptes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Famille  $famille
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $gamme = Gamme::find($id);
        $comptes = Compte::all();
        return view('admin.gammes.edit', compact('gamme','comptes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Famille  $famille
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gamme $gamme){
        $validate = $request->validate([
            'nom'=>'unique:gammes,nom,' . $gamme->id . '|required|max:255',
            'compte_id'=>'',
            'rang'=>''
        ]);

        $gamme->update($validate);

        Log::ACTION_GENEGAL("Mise à jour gamme", "L'admnistrateur " . Auth::user()->nom_complet . " a modifié la gamme : $gamme->name.");

        Session::flash('success', __('gamme.update_gam'));

        return redirect('/admin/gammes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\gamme  $gamme
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gamme $gamme)
    {
        $gamme->status= 0;
        if($gamme->update()) {
            Session::flash('success',__('gamme.success_delete'));
        } else {
            Session::flash('error', __('gamme.error_delete'));
        }

        return back();
    }
}
