<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profil;
use App\Models\Collaborateur;
use App\Models\Direction;
use App\Models\Service;
use App\Models\Departement;
use App\Models\Role;
use App\Models\Poste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Http\Custom\Log;
use App\Models\Commune;
use App\Models\Utils;
use App\Scopes\CompteScope;
use PragmaRX\Google2FA\Google2FA;

class UsersController extends Controller
{
    public $espace;
    public function __construct(User $user)
    {
        $this->espace = !$user->fournisseur?'admin':'agent';
    }
    public function index() {
        $users = User::whereHas('role',function($q){
            return $q->profil_id = 1;
        })->get();
        return view($this->espace.'.users.index', compact('users'));
    }
    public function superviseurs() {
        $users = User::superviseurs()->get();
        $title = 'Superviseurs';
        return view($this->espace.'.users.index', compact('users','title'));
    }

    public function show($id){
        $user = User::find($id);
        return view($this->espace.'.users.show', compact('user'));
    }

    public function create(){

        $user = new User();
		return view($this->espace.'.users.create',compact('user'));
	}

	public function store(Request $request){
        //Hash::make($data['password']),
        $validate = request()->validate([
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed',//|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[@#$%^&+=_!?,;-])(?=.*[A-Z])[0-9a-zA-Z!@#\$%\^\&*\)\(@#$%^&+=_!?,;-]{8,}$/|min:8',
        ]);
        $data = request()->all();
        $data['password'] = Hash::make(request('password'));
        $data['username'] = '---';
        $user = new User($data);
        return $user->create($data)
                ? ($data['profil']=='superviseur'?
                    redirect()->route($this->espace.'.users.superviseurs')->withSuccess("L'opération a été effectuée avec succès !"):
                    redirect()->route($this->espace.'.users.index')->withSuccess("L'opération a été effectuée avec succès !"))
                : redirect()->back()->withErrors("L'opération a échoué !");
	}

    public function createRole($profil_id,$user_id){
        $role = new Role();
        $role->profil_id = $profil_id;
        $role->user_id = $user_id;
        return $role->save();
    }

    public function edit($id)
	{
        $user = User::find($id);
        $communes = Commune::all();
        return view($this->espace.'.users.edit',  compact('user','communes'));
	}

    public function updateRole($user_id,$profil_id){
        $role = Role::where('user_id',$user_id)->first();
        $role->profil_id = $profil_id;
        return $role->save();
    }

    public function update(Request $request, $id){
        //dd(request('base64Img'));
        $user = User::find($id);
        $data_user = request()->all();

        // $collaborateur = $user->collaborateur;
        if($request->has('collaborateur')){
            $collab = request('collaborateur');
            $user->collaborateur->update($collab);
            unset($data_user['collaborateur']);
        }

        // $collaborateur_data = request('collaborateur');
        // $collaborateur_data['user_id'] = $user->id;
        // $profil_id = request('profil_id');
        // if($profil_id == 2) {
        //     $data_user['is_admin'] = 1;
        // }else $data_user['is_admin'] =0;
        if(request('password')!== null){
            request()->validate([
                'password' => 'required|confirmed'//|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[@#$%^&+=_!?,;-])(?=.*[A-Z])[0-9a-zA-Z!@#\$%\^\&*\)\(@#$%^&+=_!?,;-]{8,}$/|min:8',
            ]);
            $user->first_connexion = 1;
            $data_user['password'] = Hash::make(request('password'));
        }
        // dd($data_user);

        if($user->update($data_user)){
            if($request->has('images') && count($data_user['images']) > 0) Utils::savePJ($data_user['images'],'App\Models\User','profils',$user->id);

            // $this->updateRole($user->id,request('profil_id'));

            // $collaborateur = $collaborateur->update($collaborateur_data);
            // Log::ACTION_GENEGAL("update", Auth::user()->nom_complet );
            Session::flash('success', "L'utilisateur  a été modifié.") ;
        }else Session::flash('error', "error de l'operation ") ;

        return back();
    }

    public function saveSignature(Request $request, $id){
        $user = User::find($id);
        $collaborateur = $user->collaborateur;
        if(request('base64Img')){
            if(request('sign') == 1){
                if($collaborateur->url_signature) @unlink($collaborateur->url_signature) ;
                $collaborateur->url_signature = $collaborateur->saveSignature(request('base64Img'),$user);
            }else{
                if($collaborateur->url_paraph) @unlink($collaborateur->url_paraph) ;
                $collaborateur->url_paraph = $collaborateur->saveSignature(request('base64Img'),$user);
            }
            if($collaborateur->save()){
                $rep = ['info'=>"L'enregistrement a été effectué avec succès"];
            }else $rep = ['info'=>"Error de l'opération"];
        }else{
            if(request()->hasFile('url_signature')){
                if (request()->file('url_signature')->isValid()) {
                    $collaborateur->url_signature = UtilitiesController::uploadImage($_FILES['url_signature'], $collaborateur,'collaborateur','collaborateur');
                }
            }
            if(request()->hasFile('url_paraph')){
                if (request()->file('url_paraph')->isValid()) {
                    $collaborateur->url_paraph = UtilitiesController::uploadImage($_FILES['url_paraph'], $collaborateur,'collaborateur','collaborateur');
                }
            }
            if((request()->hasFile('url_signature') || request()->hasFile('url_paraph')) && $collaborateur->save()){
                Session::flash('success', "L'opération a été effectuée avec succès") ;
                return back();
            }
            Session::flash('error', "Erreur de l'opération. Veuillez réessayer") ;
            return back();
        }
        return response()->json($rep);
    }

    public function importUsersCsv(Request $request) {
        if ($request->hasFile('file') && request()->file('file')->isValid()) {
            $file_name =  $_FILES['file']['tmp_name'];
            $data_csv = UtilitiesController::read_csv($file_name);
            $result = UtilitiesController::insert_data_csv($data_csv);
            if($result){
                Session::flash('success', $result[1].' collaborateur(s) importés.');
                Session::flash('error', $result[0].' erreurs d\'importation.');
              }else   Session::flash('error',"erreurs d\'importation. Veuillez revoir le fichier importé");
        }
        return back();
    }


    public function myProfile() {
        $user = User::find(Auth::id());
        $collaborateur = $user->collaborateur;
		return view($this->espace.'.users.show',  compact('user','collaborateur' ));
    }

    public function destroy($id){
        $user = User::where('id',$id)->get()->first();
        if($user){
            $user->statut = $user->statut == 1 ? 0 : 1;
            $user->save();
            Session::flash('success', "L'opération a été effectuée avec succès") ;
            Log::ACTION_GENEGAL("delete", Auth::user()->nom_complet );
            return back();
        }
        Session::flash('error', "L'utilisateur " .$user->nom_complet . "introuvable") ;
		return back();
    }
    public function regenererQrCode($id){
        $user = User::find($id);
        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();
        $user->google2fa_secret = $secret;
        $user->is_scanned = 0;
        $user->save()?
        Session::flash('success', "L'opération a été effectuée avec succès") :
        Session::flash('error', "Erreur de l'opération. Veuillez réessayer") ;
        return back();
    }
}
