<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypeBien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TypeBiensController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $type_biens = TypeBien::actif()->get();
        $type_bien = new TypeBien();
        return view('admin.type_biens.index',compact('type_biens','type_bien'));
    }

    public function store(Request $request){
        $validate = $request->validate([
            'name'=>'unique:type_biens|required|max:255',
        ]);
       TypeBien::create($validate);
        // Log::ACTION_GENEGAL("Création famille", "L'admnistrateur " . Auth::user()->nom_complet . " a créé la famille : $type_bien->libelle.");
        Session::flash('success', __('general.success'));
        return redirect()->route('admin.type_biens.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Famille  $type_bien
     * @return \Illuminate\Http\Response
     */
    public function show(TypeBien $type_bien){
        $type_bien = $type_bien;
        return view('admin.type_biens.show',compact('famille'));
    }

    public function create(){
        $type_bien = new TypeBien();
        return view('admin.type_biens.create', compact('famille'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Famille  $type_bien
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $type_bien = TypeBien::find($id);
        return view('admin.type_biens.edit', compact('type_bien'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Famille  $type_bien
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeBien $type_bien){
        $validate = $request->validate([
            'name'=>'unique:type_biens,name,' . $type_bien->id . '|required|max:255',
        ]);
        $type_bien->update($validate);
        Session::flash('success', __('general.success'));
        return redirect()->route('admin.type_biens.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Famille  $type_bien
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeBien $type_bien){
        $type_bien->statut= 0;
        if($type_bien->update()) {
            Session::flash('success', __('general.success'));
        } else {
            Session::flash('error', __('general.delete_message'));
        }
        return back();
    }
}
