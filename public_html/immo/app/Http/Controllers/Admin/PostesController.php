<?php

namespace App\Http\Controllers\Admin;

use App\Models\Collaborateur;
use App\Http\Controllers\Controller;
use App\Http\Requests\PosteRequest;
use App\Models\Poste;
use App\Models\Direction;
use App\Models\Departement;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Custom\Log;

class PostesController extends Controller
{
    public function index() {
        $postes = Poste::all();
        return view("admin.postes.index", compact('postes'));
    }

    public function create()
    {
        $poste = new Poste();
        return view('admin.postes.create', compact('poste'));
    }



    public function store(Request $request)
    {
        $poste = Poste::create($request->all());

        if($poste){
             //LOG
             Log::ACTION_GENEGAL("Création poste",
                "L'admnistrateur " . Auth::user()->nom_complet . " a créé le poste le poste $poste->name.");

            Session::flash('success', 'Poste enregistré avec succès!') ;
            return redirect(route('admin.postes.index'));
        }
        return redirect('admin/postes');
    }

    // liste de l'entité
    public function savePoste($table, $posteData, $key = null){
        if($table == "Direction") $entity = new Direction() ;
        if($table == "Departement") $entity = new Departement() ;
        if($table == "Service") $entity = new Service() ;
        $entity = $entity::all();
        $cpt = 0;
        foreach($entity as $entite){
            $poste = new Poste();
            $poste->name = $posteData['name'];
            if($table == "Direction"){
                $poste->direction_id = $entite->id;
                $poste->save();
            }
            if($table == "Departement") {
                if($posteData['direction_id'] !== null){
                    $poste->direction_id = $posteData['direction_id'];
                }
                $poste->departement_id = $entite->id;
                $poste->save();
            }
            if($table == "Service"){
                $poste->service_id = $entite->id;
                if($posteData['departement_id'] !== null){
                    $poste->departement_id = $posteData['departement_id'];
                    if($entite->departement_id == $posteData['departement_id']){
                        $poste->service_id = $entite->id;
                        $poste->save();
                    }
                }else{
                    $poste->save();
                }
            }
            $cpt++;
        }
        if($cpt > 0){
            return true;
        }
        return null;

    }


    public function show(Poste $poste)
    {

    }

    public function edit(Poste $poste)
    {
        return view('admin.postes.edit', compact('poste'));
    }

    public function update(Request $request, Poste $poste)
    {
        if($poste->update($request->all())) {
            Session::flash('success', 'Poste mise à jour avec succès!') ;
            Log::ACTION_GENEGAL("Modification poste",
                "L'admnistrateur " . Auth::user()->nom_complet . " a modifié le poste le poste $poste->name.");
            return redirect(route('admin.postes.index'));
        }
        Session::flash('error', 'Une erreur est survenue au moment de la sauvegarde') ;
        return back();
    }

    public function destroy(Poste $poste)
    {
        if($poste->delete()) {
             //LOG
             Log::ACTION_GENEGAL("Suppression poste",
             "L'admnistrateur " . Auth::user()->nom_complet . " a supprimé le poste le poste le poste $poste->name.");
            Session::flash('success', 'Poste supprimé avec succès!') ;
        } else  Session::flash('error', 'Echec de la suppression!') ;

        return back();
    }
}
