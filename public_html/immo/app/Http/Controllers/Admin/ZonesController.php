<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Custom\Log;
use App\Models\Compte;
use App\Models\Zone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ZonesController extends Controller
{
    public function index(){
        $zones = Zone::where('statut',1)->get();
        $zone = new Zone();
        $comptes = Compte::where('status',1)->get();
        return view('admin.zones.index',compact('zones','zone','comptes'));
    }

    public function store(Request $request){
        $validate = $request->validate([
            'nom'=>'unique:zones|required|max:255',
            'compte_id'=>'',
            'rang'=>''
        ]);
        $zone = Zone::create($validate);
        Log::ACTION_GENEGAL("Création zone", "L'admnistrateur " . Auth::user()->nom_complet . " a créé la zone : $zone->nom.");
        Session::flash('success', __('zone.add_zone'));
        return redirect('admin/zones');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Famille  $famille
     * @return \Illuminate\Http\Response
     */
    public function show(Zone $zone){
        return view('admin.zones.show',compact('zone'));
    }

    public function create(){
        $zone = new Zone();
        $comptes = Compte::where('status',1)->get();
        return view('admin.zones.create', compact('zone','comptes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Famille  $famille
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $zone = Zone::find($id);
        $comptes = Compte::all();
        return view('admin.zones.edit', compact('zone','comptes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Famille  $famille
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zone $zone){
        $validate = $request->validate([
            'nom'=>'unique:zones,nom,' . $zone->id . '|required|max:255',
            'compte_id'=>'',
            'rang'=>''
        ]);
        $zone->update($validate);
        Log::ACTION_GENEGAL("Mise à jour zone", "L'admnistrateur " . Auth::user()->nom_complet . " a modifié la zone : $zone->name.");
        Session::flash('success',__('zone.update_zone'));
        return redirect('/admin/zones');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zone $zone){
        $zone->statut= 0;
        if($zone->update()) {
            Session::flash('success', __('zone.success_delete'));
        } else {
            Session::flash('error', __('zone.error_delete'));
        }
        return back();
    }
}
