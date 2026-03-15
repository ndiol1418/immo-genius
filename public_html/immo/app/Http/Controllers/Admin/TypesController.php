<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $types = Type::actif()->get();
        $type = new Type();
        return view('admin.types.index',compact('types','type'));
    }

    public function store(Request $request){
        $validate = $request->validate([
            'name'=>'unique:types|required|max:255',
        ]);
       Type::create($validate);
        // Log::ACTION_GENEGAL("Création type", "L'admnistrateur " . Auth::user()->nom_complet . " a créé la type : $type->libelle.");
        Session::flash('success', __('general.success'));
        return redirect()->route('admin.types.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type){
        $type = $type;
        return view('admin.types.show',compact('type'));
    }

    public function create(){
        $type = new Type();
        return view('admin.types.create', compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $type = Type::find($id);
        return view('admin.types.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type){
        $validate = $request->validate([
            'name'=>'unique:types,name,' . $type->id . '|required|max:255',
        ]);
        $type->update($validate);
        // Log::ACTION_GENEGAL("Mise à jour type", "L'admnistrateur " . Auth::user()->nom_complet . " a modifié la type : $type->name.");
        Session::flash('success', __('general.success'));
        return redirect()->route('admin.types.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type){
        $type->statut= 0;
        if($type->update()) {
            Session::flash('success', __('general.success'));
        } else {
            Session::flash('error', __('general.delete_message'));
        }
        return back();
    }
}