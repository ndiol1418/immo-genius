<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Direction;
use App\Models\User;
use App\Models\Poste;
use App\Http\Controllers\ApiDataController as apiData;
use Illuminate\Support\Facades\Session;
use App\Http\Custom\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class DirectionsController extends Controller
{
    public function index()
    {
        $directions = Direction::all();
        $users = User::where('etat',1)->get();
        $postes = Poste::All();
        return view('admin.directions.index', compact('directions','users','postes'));
    }

    public function show(Direction $direction)
    {
        //
    }


    public function edit(Direction $direction)
    {
        //
    }

    public function store(Request $request)
	{
       // dd(request()->all());
        $data = request()->validate([
            "name" => 'required',
            'etat' => 'nullable',
            'poste_id'=>''
        ]);
        $direction = Direction::create($data);
        Session::flash('success', 'La direction a été créée.') ;
		return redirect('admin/directions');
	}

    public function update(Request $request, Direction $direction)
    {
        $data = request()->validate([
            "name" => 'required',
            'etat' => 'nullable',
            'poste_id'=>''
        ]);
        $direction->update($data);
        Session::flash('success', 'La direction a été modifiée.') ;
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Direction  $direction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Direction $direction)
    {
        if($direction->delete()) {
            //LOG
           // LogType::ACTION_GENEGAL("Suppression direction", "L'admnistrateur " . Auth::user()->nom_complet . " a supprimé la direction : $direction->name.");
            Session::flash('success', 'La direction a été supprimée avec succès!') ;
        } else {
            flash('Echec de la suppression!')->error();
        }

        return back();
    }

    public function getDirectionsFromCentral() {
        if(apiData::saveOrUpdateDirections()) {
            Session::flash('success', "Les directions ont été mises à jour avec succès !");
            Log::ACTION_GENEGAL("Mise à jour des directions", "L'admnistrateur " . Auth::user()->nom_complet . " a mis à jour les directions avec succés.");
        } else {
            Session::flash('error', "La mise à jour des directions a échoué !");
            Log::ACTION_GENEGAL("Mise à jour des directions", "L'admnistrateur " . Auth::user()->nom_complet . " a mis à jour les directions sans succés.");
        }
        return redirect()->route("admin.directions.index");
    }


}
