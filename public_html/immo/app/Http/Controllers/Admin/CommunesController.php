<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commune;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CommunesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $communes = Commune::actif()->get();
        $departements = Departement::actif()->get();
        $commune = new Commune();
        return view('admin.communes.index',compact('communes','departements','commune'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = request()->validate([
            'name'=>'unique:departements|required|max:255',
            'departement_id'=>'required|exists:departements,id'

        ]);
        $departement = Commune::create($validate);
        //LOG
        Session::flash('success', "Le département a été créé.");
		return redirect('admin/communes');
    }

    public function show(Departement $departement)
    {
        //
    }

    public function update(Request $request, Commune $commune)
    {
        $validate = $request->validate([
            'name'=>'unique:communes,name,' . $commune->id . '|required|max:255',
            'departement_id'=>'required|exists:departements,id'
        ]);
        $commune->update($validate);
        Session::flash('success', "Le département a été mis a jour avec succès.");

        return redirect('/admin/communes');
    }

    public function destroy(Commune $commune)
    {
        if($commune->update(['status'=>0])) {
            Session::flash('success', "Le département a été supprimé avec succès.");
        } else {
            Session::flash('error', "La suppression a échoué.");
        }
        return back();
    }


}
