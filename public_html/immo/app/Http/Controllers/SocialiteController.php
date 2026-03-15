<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite as FacadesSocialite;

class SocialiteController extends Controller
{
    // Les tableaux des providers autorisés
    protected $providers = [ "google", "github", "facebook" ];

    # La vue pour les liens vers les providers
    public function loginRegister () {
    	return view("socialite.login-register");
    }

    # redirection vers le provider
    public function redirect (Request $request) {

        $provider = $request->provider;
        // On vérifie si le provider est autorisé
        if (in_array($provider, $this->providers)) {
            return FacadesSocialite::driver($provider)->redirect(); // On redirige vers le provider
        }
        abort(404); // Si le provider n'est pas autorisé
    }

    // Callback du provider
    public function callback (Request $request) {

        $provider = $request->provider;

        if (in_array($provider, $this->providers)) {

        	// Les informations provenant du provider
        	$data = FacadesSocialite::driver($request->provider)->user();

            // Les informations de l'utilisateur
            $user = $data->user;
            self::inscription($user);
            return redirect('/');
            // voir les informations de l'utilisateur
         }
         abort(404);
    }

    static function inscription ($data){

        $email = $data['email'];
        $client_data['nom'] = $data['family_name'];
        $client_data['prenom'] = $data['given_name'];
        DB::beginTransaction();
        $exist = User::where('email', $email)->first();
        if($exist){
            Auth::login($exist);
        }else{

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'password' => bcrypt(uniqid()), // si nouvel utilisateur
                ]
            );
            if($user){
                DB::commit();
                $user->createRole(3,$user->id);
                $client_data['user_id'] = $user->id;
                if(Client::create($client_data)){
                    Auth::login($user);
                }
                DB::rollBack();
            }
        }

    }
}