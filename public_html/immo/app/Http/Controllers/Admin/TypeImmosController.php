<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypeImmo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TypeImmosController extends Controller
{
    public function index(){
        $type_immos = TypeImmo::actif()->get();
        $type_immo = new TypeImmo();
        return view('admin.type_immos.index',compact('type_immos','type_immo'));
    }

    public function store(Request $request){
        $validate = $request->validate([
            'name'=>'unique:type_immos|required|max:255',
        ]);
       TypeImmo::create($validate);
        // Log::ACTION_GENEGAL("Création type_immo", "L'admnistrateur " . Auth::user()->nom_complet . " a créé la type_immo : $type_immo->libelle.");
        Session::flash('success', __('general.success'));
        return redirect()->route('admin.type_immos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\type_immo  $type_immo
     * @return \Illuminate\Http\Response
     */
    public function show(TypeImmo $type_immo){
        return view('admin.type_immos.show',compact('type_immo'));
    }

    public function create(){
        $type_immo = new TypeImmo();
        return view('admin.type_immos.create', compact('type_immo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\type_immo  $type_immo
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $type_immo = TypeImmo::find($id);
        return view('admin.type_immos.edit', compact('type_immo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\type_immo  $type_immo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeImmo $type_immo){
        $validate = $request->validate([
            'name'=>'unique:type_immos,name,' . $type_immo->id . '|required|max:255',
        ]);
        $type_immo->update($validate);
        Session::flash('success', __('general.success'));
        return redirect()->route('admin.type_immos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\type_immo  $type_immo
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeImmo $type_immo){
        $type_immo->statut= 0;
        if($type_immo->update()) {
            Session::flash('success', __('general.success'));
        } else {
            Session::flash('error', __('general.delete_message'));
        }
        return back();
    }
}
