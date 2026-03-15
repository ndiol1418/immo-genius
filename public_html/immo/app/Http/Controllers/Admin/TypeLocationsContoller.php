<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypeLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TypeLocationsContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $type_locations = TypeLocation::actif()->get();
        $type_location = new TypeLocation();
        return view('admin.type_locations.index',compact('type_locations','type_location'));
    }

    public function store(Request $request){
        $validate = $request->validate([
            'name'=>'unique:type_locations|required|max:255',
        ]);
       TypeLocation::create($validate);
        // Log::ACTION_GENEGAL("Création type_location", "L'admnistrateur " . Auth::user()->nom_complet . " a créé la type_location : $type_location->libelle.");
        Session::flash('success', __('general.success'));
        return redirect()->route('admin.type_locations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\type_location  $type_location
     * @return \Illuminate\Http\Response
     */
    public function show(TypeLocation $type_location){
        return view('admin.type_locations.show',compact('type_location'));
    }

    public function create(){
        $type_location = new TypeLocation();
        return view('admin.type_locations.create', compact('type_location'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\type_location  $type_location
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $type_location = TypeLocation::find($id);
        return view('admin.type_locations.edit', compact('type_location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\type_location  $type_location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeLocation $type_location){
        $validate = $request->validate([
            'name'=>'unique:type_locations,name,' . $type_location->id . '|required|max:255',
        ]);
        $type_location->update($validate);
        Session::flash('success', __('general.success'));
        return redirect()->route('admin.type_locations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\type_location  $type_location
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeLocation $type_location){
        $type_location->statut= 0;
        if($type_location->update()) {
            Session::flash('success', __('general.success'));
        } else {
            Session::flash('error', __('general.delete_message'));
        }
        return back();
    }
}
