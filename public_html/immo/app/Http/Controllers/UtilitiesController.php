<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Info;
use App\Models\Collaborateur;
use App\Models\Role;
use App\Models\User;
use App\Models\Direction;
use App\Models\Service;
use App\Models\Departement;
use App\Models\Poste;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

class UtilitiesController extends Controller
{
    static function uploadFile(UploadedFile $uploadFile, $folder,array $extensions = [], $randomName = "upload") {
        if($uploadFile->isValid() && in_array(strtolower($uploadFile->extension()), $extensions)) {
            $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
            $rand = substr(str_shuffle(str_repeat($alphabet, 20)),0, 4);
            $filename =  $rand . Str::slug($randomName) . '.' . $uploadFile->extension();
            try {
                $file = $uploadFile->move(public_path($folder), $filename);
                $path = $folder. '/' . $filename;
                return $path; //Update Image
            } catch (\Throwable $th) {
                return false;
            }
        }

        return false;
    }

    static function removeFile($relativepath) {
        $file_path = public_path($relativepath);
        if($relativepath && file_exists($file_path)) {
            unlink($file_path);
        }
    }

    static function bindFieldsToInfos($fields, $infos) {
        foreach ($fields as $field) {
            $field->info = self::getInfoByFielID($field->id, $infos);
        }

        return $fields;
    }

    static function getInfoByFielID($field_id, $infos) {
        if(count($infos) > 0) {
            foreach ($infos as $info) {
                if($info->field_id == $field_id) {
                    return $info;
                }
            }
        }
        return null;
    }

    static function saveOrUpdateInfos($document_id, $arraySubmitInfos, $extensions = []) {
        if(isset($arraySubmitInfos) && count($arraySubmitInfos) > 0) {
            foreach($arraySubmitInfos as $field_id => $value) {
                $infoAlreadyExist = Info::where('field_id', $field_id)
                                        ->where('document_id',$document_id)
                                        ->orderByDesc('updated_at')
                                        ->first();
                //Value field
                if(is_array($value)) {
                    try {
                        //Differencier le champs pièce jointe des autres champs
                        $field = Field::find($field_id);

                        if($field->type_field_id != 10) { // si ce n'est pas un champ piece jointe
                            if($field->type_field_id == 8 && !($field->dynamic == 1)) { //TYPE GRILLE STATIQUE
                                $newArray = [];
                                for($i= 0; $i < count($value); $i++) {
                                    $tmp_value = $value[$i];
                                    $without_space = str_replace(' ', '', $tmp_value);
                                    if(is_numeric($without_space)) {
                                        $tmp_value = $without_space;
                                    }
                                    array_push($newArray, implode(';', $tmp_value));
                                }
                                $value = implode('|', $newArray);
                            }
                            else {
                                $value = implode(";", $value);
                            }
                        }
                        else { // S'il s'agit d'une pièce jointe
                            //Verification que nous avons bien un fichier
                            $isFile = true;
                            if(isset($value)) {
                                $newInfo = new Info();
                                $newInfo->document_id = $document_id;
                                $newInfo->value = "save_doc";
                                $newInfo->field_id = $field_id;
                                if($newInfo->save()) {
                                    $uploadResult = self::uploadFile($value,"addional_infos", $extensions);
                                    if($uploadResult) {
                                        //Update
                                        $newInfo->value = $uploadResult;
                                        $newInfo->save();
                                    } else {
                                        $newInfo->value = "error_saving";
                                    }
                                } else {
                                    $newInfo->delete();
                                }

                                //Sortir d'un pas de la boucle
                                continue;
                            }
                        }

                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                }

                if($infoAlreadyExist && !isset($isFile)) {
                    //Supression des autres Infos
                    Info::where('field_id', $field_id)
                    ->where('document_id',$document_id)
                    ->where('id', '!=', $infoAlreadyExist->id)->delete();

                    $infoAlreadyExist->value = $value;
                    if(!$infoAlreadyExist->save()) return false;
                } elseif(!$infoAlreadyExist && !isset($isFile)) {
                    $newInfo = new Info();
                    $newInfo->document_id = $document_id;
                    $newInfo->value = $value;
                    $newInfo->field_id = $field_id;
                    if(!$newInfo->save()) return false;
                }
            }
        }
        return true;
    }


    static function uploadImage($fichier, $entity, $dossier, $nom = null)
    {
        $file_name = $fichier['name'];
        $file_tmp = $fichier['tmp_name'];

        $ext = pathinfo($file_name, PATHINFO_EXTENSION);

        $target_dir = public_path('images/'.$dossier);
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }


        $newFileName =  "plateforme-" . $entity->id . '.' . $ext;
        $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
        $rand = substr(str_shuffle(str_repeat($alphabet, 20)),0, 4);
        if(isset($nom)) $newFileName =  $nom. '-' .$rand. $entity->id . '.' . $ext;

        $desti_file = $target_dir . '/' . $newFileName;

        if(move_uploaded_file($file_tmp, $desti_file)) {
            return "images/".$dossier."/".$newFileName;
        }
        return false;
    }

    static function read_csv($filename){
        // ouverture du fichier
        $FILE = fopen($filename, "r");
        // lire ligne par ligne et couper colonne par colonne
        while ($ARRAY[] = fgetcsv($FILE, 1024, ";"));
        // fermer le fichier
        fclose($FILE);
        // effacer la dernière ligne
        array_pop($ARRAY);
        // renvoi le tableau
        return $ARRAY;
      }

    static function insert_data_csv($data_csv) {
       //dd($data_csv);
        $ok=0;
        $nok=0;
        $result = [];
        try {
            foreach (array_slice($data_csv, 1) as $line) {
                $user = User::where('email',$line[2])->first();
                if(!$user){
                    $user = new User();
                }
                //dd($user);
               // $user->username = 'test';

                $user->email = $line[3];
                $user->remember_token = null;
                $user->is_admin = 0;
                $user->password = Hash::make('Passer123!');
                $user->etat = 1;
                //dd($user);

                if($user->save()){
                    $role = Role::where('user_id',$user->id)->first();
                    if(!$role){
                        $role = new Role();
                    }
                    $role->user_id = $user->id;
                    $role->profil_id = 1;
                    if($role->save()){
                        $collaborateur = Collaborateur::where('user_id',$user->id)->first();
                        if(!$collaborateur){
                            $collaborateur = new Collaborateur();
                        }
                        $collaborateur->prenom = $line[0];
                        $collaborateur->nom = $line[1];
                        $collaborateur->matricule = $line[2];
                        $collaborateur->igg = $line[6];
                        $collaborateur->genre = 1;
                        $collaborateur->user_id = $user->id;

                        $poste = Poste::where('name',$line[9])->first();
                        if(!$poste){
                            $poste = new Poste();
                        }
                        $poste->name = $line[9];
                        $poste->etat = 1;

                        if($poste->save()){
                            $collaborateur->poste = $poste->name;
                            $collaborateur->poste_id = $poste->id;
                        }

                        $direction = Direction::where('name',$line['11'])->first();
                        if(!$direction){
                            $direction = new Direction();
                        }
                        $direction->name = $line['11'];
                        $direction->etat = 1;


                        if($direction->save()){
                            $collaborateur->direction_id = $direction->id;
                            $departement = Departement::where('name',utf8_encode($line['13']))->first();
                            if(!$departement){
                                $departement = new Departement();
                            }
                            $departement->name = utf8_encode($line['13']);
                            $departement->direction_id = $direction->id;
                            $departement->etat = 1;
                            //dd($departement);
                            if($departement->save()){
                                $collaborateur->departement_id = $departement->id;
                            }

                            $service = Service::where('name',utf8_encode($line['12']))->first();
                            if(!$service){
                                $service = new Service();
                            }
                            $service->name = utf8_encode($line['12']);
                            $service->etat = 1;
                            $service->direction_id = $direction->id;
                            if($service->save()){
                                $collaborateur->service_id = $service->id;
                            }
                        }
                        if($collaborateur->save()){
                            $ok++;
                        }
                    }

                }else $nok++;
            }
            $result = [0=>$nok,1=>$ok];
            return $result;
        } catch (Exception $e) {
            echo 'erreur : ',  $e->getMessage(), "\n";
        }
    }
    public static function _token(int $taille){
        $length = $taille;
        // debug($length);
        $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ$';
        $taillechar = strlen($char);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $char[rand(0, $taillechar - 1)];
        }
        return $randomString;
    }

}
