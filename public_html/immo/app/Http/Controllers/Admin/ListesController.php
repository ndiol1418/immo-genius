<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Custom\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Liste;

class ListesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $listes= Liste::all();
        return view('admin.listes.index',compact('listes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $liste = new Liste();
        return view('admin.listes.create',compact('liste'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $data = $request->all();
        if ($request->hasFile('file') && request()->file('file')->isValid()) {
            $file_name =  $_FILES['file']['tmp_name'];
            $valeurs = Liste::DataAttrWithCsv($file_name);
            $data['valeurs'] = utf8_encode($valeurs);
        }
        unset($data['_token'],$data['file']);
        $liste = Liste::create($data);
        if($liste){
            if(!$liste->verifIdentifiant()){
                $liste->identifiant = 'id';
            }
            $liste->label = $data['label'];
            $liste->save();
            Session::flash('success', "La liste a été créée avec succès !");
            Log::ACTION_GENEGAL("Crèation d'une liste", "L'admnistrateur " . Auth::user()->nom_complet . " a créé la liste ".$liste->libelle);
        }else  Session::flash('error', "erreur de création de la liste");
        return redirect('admin/listes');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $liste = Liste::find($id);
        return view('admin.listes.show',compact('liste'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $liste = Liste::find($id);
        return view('admin.listes.edit',compact('liste'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $liste = Liste::find($id);
        $data = $request->all();
        if ($request->hasFile('file') && request()->file('file')->isValid()) {
            $file_name =  $_FILES['file']['tmp_name'];
            $valeurs = Liste::DataAttrWithCsv($file_name);
            $data['valeurs'] = utf8_encode($valeurs);
        }
        unset($data['_token'],$data['file']);
        $liste->label = $data['label'];
        if($liste->update($data)){
            Session::flash('success', "La liste a été mise a jour avec succès !");
            Log::ACTION_GENEGAL("Modification d'une liste", "L'admnistrateur " . Auth::user()->nom_complet . " a modifié la liste ".$liste->libelle);
        }else Session::flash('error', "erreur de modification de la liste");
        return redirect('admin/listes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $liste = Liste::find($id);
        if($liste->delete()){
            Session::flash('success', "La liste a été supprimée a jour avec succès !");
            Log::ACTION_GENEGAL("Suppression d'une liste", "L'admnistrateur " . Auth::user()->nom_complet . " a modifié la liste ".$liste->libelle);
        }else Session::flash('error', "erreur de suppression de la liste");
        return back();
    }
}
