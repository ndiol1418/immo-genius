<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiDataController as apiData;
use App\Models\Departement;
use App\Models\Direction;
use App\Models\User;
use App\Models\Poste;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Custom\Log;

class DepartementsController extends Controller
{
    public function index()
    {
        $departements = Departement::all();
        return view('admin.departements.index', compact('departements'));
    }

    public function store(Request $request)
    {
        $validate = request()->validate([
            'name'=>'unique:departements|required|max:255',

        ]);

        $departement = Departement::create($validate);
        //LOG
        Session::flash('success', "Le département a été créé.");
		return redirect('admin/departements');
    }

    public function show(Departement $departement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Departement  $departement
     * @return \Illuminate\Http\Response
     */
    public function edit(Departement $departement)
    {
        $departement = Departement::find($departement->id);
        $directions = Direction::all();
        $users = User::where('etat',1)->get();
        $postes = Poste::all();

        return view('admin.departements.edit', compact('departement','directions','users','postes'));

    }

    public function update(Request $request, Departement $departement)
    {
        $validate = $request->validate([
            'name'=>'unique:departements,name,' . $departement->id . '|required|max:255',


        ]);
        $departement->update($validate);
        Session::flash('success', "Le département a été mis a jour avec succès.");

        return redirect('/admin/departements');
    }

    public function destroy(Departement $departement)
    {
        if($departement->update(['status'=>0])) {
            Session::flash('success', "Le département a été supprimé avec succès.");
        } else {
            Session::flash('error', "La suppression a échoué.");
        }
        return back();
    }

    public function getDepartementsFromCentral() {
        if(apiData::saveOrUpdateDepartements()) {
            Session::flash('success', "Les départements ont été mises à jour avec succès !");
        } else {
            Session::flash('error', "La mise à jour des départements a échoué !");
        }
        return redirect()->route("admin.departements.index");
    }
}
