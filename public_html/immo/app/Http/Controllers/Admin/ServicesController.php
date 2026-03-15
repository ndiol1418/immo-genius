<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiDataController as apiData;
use App\Models\Service;
use App\Models\User;
use App\Models\Poste;
use App\Models\Departement;
use App\Models\Direction;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Custom\Log;

class ServicesController extends Controller
{
    public function index()
    {
        $services = Service::with(['direction', 'departement'])->get()->all();
        $users = User::where('etat',1)->get();
        $postes = Poste::all();

        return view('admin.services.index',compact('services','users','postes'));
    }

    public function store(Request $request)
    {
        //
        $validator = $request->validate([
            'name'=> 'required|max:255'
        ]);
        $service = Service::create(
            request()->all()
        );

        Log::ACTION_GENEGAL("Création service", "L'admnistrateur " . Auth::user()->nom_complet . " a créé un nouveau service : $service->name.");

        Session::flash('success', "Le service a été créé.");

        return redirect('admin/services');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
        $service = $service;
        return view('admin.services.show',compact('service'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service){
        //
        $departements = Departement::all();
        $users = User::where('etat',1)->get();
        $postes = Poste::all();
        $directions = Direction::all();
        return view('admin.services.edit', compact('service','departements','directions','users',"postes"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        //
        //dd($request->all());
        $validate = $request->validate([
            'name'=>'required|max:255',
            'direction_id'=>'',
            'departement_id'=>'',
            'poste_id'=>''
        ]);



        $service->update($validate);
        Log::ACTION_GENEGAL("Mise à jour service", "L'admnistrateur " . Auth::user()->nom_complet . " a modifié le service : $service->name.");

        Session::flash('success', "Le service a été modifié avec succès.");

        return redirect('/admin/services');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        if($service->delete()) {
            Session::flash('success', "Le service a été supprimé avec succès!");
        } else {
            Session::flash('error', "Echec de la suppression!");
        }

        return back();
    }

    public function getServicesFromCentral() {
        if(apiData::saveOrUpdateServices()) {
            Session::flash('success', "Les services ont été mises à jour avec succès !");
        } else {
            Session::flash('error', "La mise à jour des services a échoué !");
        }
        return redirect()->route("admin.services.index");
    }
}
