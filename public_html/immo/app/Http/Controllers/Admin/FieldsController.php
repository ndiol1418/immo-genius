<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FieldRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Custom\Log;
use App\Models\Field;
use App\Models\TypeDocument;
use Illuminate\Support\Facades\Session;

class FieldsController extends Controller
{
    public function store(FieldRequest $request)
    {
        $field = new Field(request()->all());
        if($field->save()) {
            //LOG
            Log::ACTION_GENEGAL("Création nouveau champ dynamique",
                    "L'admnistrateur " . Auth::user()->nom_complet . " a créé un nouveau champ : $field->name pour le workflow ".$field->type_document->name.".");

            Session::flash("success",'Le champ a été ajouté avec succès!');
        } else {
            Session::flash("error",'Le champ n\'a pas pû être enregistré!');
        }

        return back();
    }

    public function ranger(Request $request, $type_document_id) {
        $fields = Field::all()->where('type_document_id', '=', $type_document_id);
        $type_document = TypeDocument::find($type_document_id);

        $temp = $request->all();

        if(count($fields) > 0) {
            foreach($fields as $champ) {
                $rang = (int) $temp['champs'.$champ->id];

                $champ->rang = $rang + 1;
                $champ->save();
            }

            //LOG
            Log::ACTION_GENEGAL("Rangement champs dynamiques",
                    "L'admnistrateur " . Auth::user()->nom_complet . " a rangé les champs pour le workflow ".$type_document->name.".");

            Session::flash("success",'Les champs ont été réorganisés avec succès.');
        }

        return back();
    }

    public function update(Request $request, Field $field)
    {
        if($field->update(request()->all())) {
            Session::flash("success",'Le champ a été mis à jour avec succès!');

            //LOG
            Log::ACTION_GENEGAL("Modification champ dynamique",
                "L'admnistrateur " . Auth::user()->nom_complet . " a modifé le champ : $field->name pour le workflow ".$field->type_document->name.".");
        } else {
            Session::flash("error",'Le champ n\'a pas pû mis à jour!');
        }

        return back();
    }

    public function destroy(Field $field)
    {
        if($field->delete()) {
            //LOG
            Log::ACTION_GENEGAL("Suppression champ dynamique",
                "L'admnistrateur " . Auth::user()->nom_complet . " a supprimé le champ : $field->name pour le workflow ".$field->type_document->name.".");

            Session::flash("success",'Le champ a été supprimé avec succès!');
        } else {
            Session::flash("error",'Echec lors de la suppression du champs!');
        }

        return back();
    }
}
