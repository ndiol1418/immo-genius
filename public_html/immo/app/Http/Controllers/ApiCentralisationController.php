<?php

namespace App\Http\Controllers;

use App\Http\Custom\Log;
use App\Models\Collaborateur;
use App\Models\Profil;
use App\Models\Role;
use App\Models\TmpRequest;
use App\Models\User;
use App\Models\Poste;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class ApiCentralisationController extends Controller
{

    public function login()
    {
        $rep = null;
        $email = request('email');
        $user = User::where('email', $email)->where('etat', 1)->first();

        if($user) {
            if($user->etat) {
                $rep['user'] = $user;
                $rep['endpoint'] = route('home');
                $rep['redirect_to'] = route('centralisation.redirect', [
                    'authId' => $user->id,
                    'endpoint' => $rep['endpoint']
                ]);
            } else  {
                $rep = ['error' => 'Votre accès ont été désactivés. Merci de contacter votre administrateur.'];
            }
        } else {
            $rep = ['error' => 'Votre username ou mot de passe est incorrect.'];
        }

        return response()->json($rep);
    }

    public function loginRedirectFromCentral(Request $request){
        $user_id = request()->query("authId");
        $endpoint = request()->query('endpoint');

        try {
            //Connexion user
            $user = User::find($user_id);

            Auth::login($user);

            //LOG
            Log::ACTION_GENEGAL("Connexion", "Connnexion de " . Auth::user()->nom_complet . ".");

            return redirect($endpoint);

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function connexionPlateforme() {
        $rep = null;
        $tmp_plateforme = request('plateforme');

        $db_plateforme = DB::table('config')->where('id_plateform', $tmp_plateforme['id_plateform'])->first();
        if(!$db_plateforme) {
            $isInsert = DB::table('config')->insert([
                    'id_plateform' => $tmp_plateforme['id_plateform'],
                    'token' => $tmp_plateforme['token']
                ]);
            if($isInsert) {
                $rep = ['success' => 'Mise à jour avec succès'];
            }
        }

        return response()->json($rep);
    }

    public function getProfiles() {
        $profils = Profil::where("etat",1)->pluck("name")->toArray();
        return response()->json($profils);
    }

    public function update() {
        $tmp = request()->all();
        $user_tmp = $tmp['user'];
        $collaborateur_tmp = $tmp['collaborateur'];
        $managers = $tmp['managers'] ?? [];

        //remove ID and User_id
        unset($collaborateur_tmp['id']);
        unset($collaborateur_tmp['user_id']);
        unset($user_tmp['etat']);

        $user_db = User::where('email', $user_tmp['email'])->with('collaborateur')->first();

        if($user_db) {
            if($user_db->collaborateur) {
                $collaborateur = $user_db->collaborateur;
            }
        } else {
            if($tmp['create_new']) {
                $user_db  = new User();
                $collaborateur  = new Collaborateur();

                if(!isset($user_tmp['password'])) {
                    $user_tmp['password'] = $user_tmp['email'];
                }
            }
        }

        //ENREGISTREMENT DES INFORMATIONS
        if($user_db) {
            //Update user
            $user_db = $this->patchEntity($user_db, $this->getEditableAttributes($user_db, ['password','is_admin', 'etat']),$user_tmp);

            if(isset($user_tmp['password'])) {
                $user_db->password = Hash::make($user_tmp['password']);
            }


            //Sauvegarder le user pour creer le collaborateuur
            if($tmp['create_new']) {
                if($user_db->save() && isset($collaborateur)) {
                    $collaborateur->user_id = $user_db->id;
                }
            }


            //Gestion des profils user
            if(isset($tmp['user_profils']) && count($tmp['user_profils']) > 0) {
                    $user_profils = $tmp['user_profils'];
                    //Mise à jour des profils
                    if(in_array('Administrateur', $user_profils)) {
                        $user_db->is_admin = 1;
                    } else {
                        $user_db->is_admin = 0;
                    }
                    $user_db->etat = 1;
                    //Instancier Le Role
                    //--Si le role n'existe pas
                    //--On le cree
                    if(isset($user_db->id)) $this->createOrUpdateRoles($user_db->id, $user_profils); //MAJ des Roles
                } else {
                    if(isset($user_db->id)) {
                        Role::where('user_id', $user_db->id)->delete(); //Suppression des roles
                        $user_db->etat = 0;
                        $user_db->is_admin = 0;
                        $user_db->save();
                    }
            }

            //Si le collaborateur n'existe pas
            if(!isset($collaborateur)) {
                $collaborateur  = new Collaborateur();
                $collaborateur->user_id = $user_db->id;
                $collaborateur->igg = 0000000;
            }

            if(isset($collaborateur)) {
                //Verifiez la suppression
                if(isset($user_tmp['deleted'])) {
                    $user_db->etat = 0; //Désactiver
                }

                //Update Collaborateur
                $collaborateur = $this->patchEntity($collaborateur, $this->getEditableAttributes($collaborateur),$collaborateur_tmp);
                if(!isset($collaborateur)){
                    $collaborateur->nom = $collaborateur_tmp['nom'];
                    $collaborateur->prenom = $collaborateur_tmp['prenom'];
                    $collaborateur->matricule = $collaborateur_tmp['matricule'];
                    $collaborateur->photo = $collaborateur_tmp['photo'];
                    $collaborateur->poste_old = $collaborateur_tmp['poste'];
                    $poste = Poste::where('name',$collaborateur_tmp['poste'])->first();
                    $collaborateur->telephone = $collaborateur_tmp['telephone'];
                    $collaborateur->mobile = $collaborateur_tmp['mobile'];
                    $collaborateur->genre = $collaborateur_tmp['genre'];
                    $collaborateur->fincode = $collaborateur_tmp['fincode'];
                    $collaborateur->igg = $collaborateur_tmp['igg'];
                    $collaborateur->naissance = $collaborateur_tmp['naissance'];
                    if($poste) $collaborateur->poste_id =  $poste->id;
                    $collaborateur->entree = $collaborateur_tmp['entree'];
                    $collaborateur->sortie = $collaborateur_tmp['sortie'];
                    $collaborateur->direction_id = $collaborateur_tmp['direction_id'];
                    $collaborateur->departement_id = $collaborateur_tmp['departement_id'];
                    $collaborateur->service_id = $collaborateur_tmp['service_id'];
                }
                if($user_db->save() && $collaborateur->save()) {

                    //Update Managers
                    $this->updateManagers($managers, $collaborateur);

                    $rep = ['success' => 'Le collaborateur a été mise jour dans Innodays'];
                } else {
                    $rep = ['error' => 'La mise à jour du collaborateur a échoué sur Innodays'];
                }
            }

        } else {
            $rep = ['error' => 'Collaborateur Introuvable sur Innodays !'];
        }

        return response()->json($rep);
    }

    public function authorizeRequest() {
        $token = new TmpRequest();

        $app_key = request('app_key');
        $_token = request('_token');

        //INITIALISE KEY OF CENTRALISATION
        $CENTRALISATION_KEY = env('CENTRALISATION_KEY', "cle_inexistant");

        if($app_key == $CENTRALISATION_KEY) {
            $token->_token = $_token;

            if($token->save()) {
                $rep = $token;
            }
        } else {
            $rep = ['error' => 'La clé de l\'application ne correspond pas !'];
            return response()->json($rep, 403);
        }

        return response()->json($rep);
    }

    //Recevoir les champs pour mise à jour - excludes => les champs à exclure
    private function getEditableAttributes(Model $entity, array $excludes = []) {
        try {
            $model_fields = Schema::getColumnListing($entity->getTable());
            return array_diff($model_fields, array_merge(['id'],$excludes));
        } catch (\Throwable $th) {
            return [];
        }
    }

    //Mise à jour des attributs
    private function patchEntity(Model $entity,array $editableAttributes = [], array $data = []) {
        try {
            if($editableAttributes && count($editableAttributes) > 0) {
                foreach ($editableAttributes as $field) {
                    if(isset($data[$field])) {
                        $entity->{$field} = $data[$field];
                    }
                }
            }
            return $entity;
        } catch (\Throwable $th) {
            return $entity;
        }
    }

    //Mise à jour des roles utilisateur
    private function createOrUpdateRoles($user_id, $profils) {
        if(count($profils) && isset($user_id)) {
            foreach ($profils as $profil_name) {
                $profil = Profil::where('name', $profil_name)->first();
                if($profil) {
                    $role = Role::where('user_id', $user_id)
                                          ->where('profil_id',$profil->id)->first();

                    if(!$role) {
                        $role = Role::create([
                            'user_id' => $user_id,
                            'profil_id' => $profil->id
                        ]);
                    }

                    //Delete other roles
                    Role::where('user_id', $user_id)
                        ->where('id', '<>', $role->id)
                        ->delete();
                }
            }
        }
    }

    private function updateManagers(array $managers, Collaborateur $collaborateur){
        if(count($managers)) {
            foreach ($managers as $n => $manager) {
                $user = User::where('email', $manager['email'])->first();
                if($user) {
                    $collaborateur->{"manager_".$n} = $user->collaborateur->id ?? null;
                }else{
                    $collaborateur->{"manager_".$n} = null;
                }
            }
            if(count($managers)==2){
                $collaborateur->{"manager_3"} = null;
            }elseif(count($managers) ==1){
                $collaborateur->{"manager_2"} = null;
                $collaborateur->{"manager_3"} = null;
            }
            $collaborateur->save();
        }
    }
}
