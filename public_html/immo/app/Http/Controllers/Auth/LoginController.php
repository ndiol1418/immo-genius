<?php

namespace App\Http\Controllers\Auth;

use App\Events\MailEvent;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\JsonResponse;
use PragmaRX\Google2FA\Google2FA;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = "admin/tableau-de-bord";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('throttle:5,1')->only('login');
    }

    public function showLoginForm()
    {
        if(!env('APP_DEBUG')) {
            if(env("CENTRALISATION_LINK")) {
                return redirect(env("CENTRALISATION_LINK"));
            }
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $user = User::where('email',request('email'))->first();
        if(isset($user) && $user->status == 1){
            if(Session::token() != request('_token')) {
                return redirect()->route('login');
            }
            $this->validateLogin($request);

            if(method_exists($this, 'hasTooManyLoginAttempts') &&
                $this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);
                return $this->sendLockoutResponse($request);
            }

            if($this->attemptLogin($request)) {
                return $this->sendLoginResponse($request);
            }
            $this->incrementLoginAttempts($request);
        }
        return $this->sendFailedLoginResponse($request);
    }
    public function authenticated(Request $request, $user)
    {
        if ($user->google2fa_enabled) {
            $google2fa = new Google2FA();
            // $google2fa->setWindow(4);

            $secret = $user->google2fa_secret ? $user->google2fa_secret : $google2fa->generateSecretKey();
            $user->google2fa_secret = $secret;
            $otp_secret = $user->google2fa_secret;

            $one_time_password = $google2fa->getCurrentOtp($otp_secret);
            $user->save();
            if ($request->session()->has('2fa_passed')) {
                $request->session()->forget('2fa_passed');
            }

            $request->session()->put('2fa:user:id', $user->id);
            $request->session()->put('2fa:auth:attempt', true);
            $request->session()->put('2fa:auth:remember', $request->has('remember'));

            try {
                // User::sendCode2Fa($user,$one_time_password);
            } catch (\Throwable $th) {
                //throw $th;
                dd($th);

            }
            $inlineUrl = $google2fa->getQRCodeUrl(
                'TEMS',
                'E-commande',
                $secret
            );

            $inlineUrl = QrCode::size(100)->generate($inlineUrl);
            return view('auth.2fa',compact('secret','inlineUrl','user'));
            // return redirect()->route('2fa')->with('one_time_password', $one_time_password);
        }

        return redirect()->intended($this->redirectPath());
    }
/*
    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        $endpoint = route('home');
        $user = User::with(['role.profil'])->where('users.email',$credentials['email'])->first();

        if($user == null) {
            $request->session()->flash('error','Accès refusé. Veuillez vérifier vos identifiants');return back();
        }
        if($user->etat == 0) {
            $request->session()->flash('error',"Accès refusé. Vous n'êtes pas autorisé à accéder à la plateforme");
            return redirect()->route('login');
        }

        isset($user->roles) && $user->roles ?  $profil_id = $user->roles->profil_id : $profil_id =null;

        dd(Auth::check($credentials));
        if(Auth::attempt($credentials)) {
            dd( $credentials);
            $request->session()->flash('success','Bienvenue, votre connexion a réussi.');
            return redirect($endpoint);
        } else {
            $request->session()->flash('error','Accès refusé. Veuillez vérifier vos identifiants');
            return redirect()->route('login');
        }
    }
*/
    public function loginRedirect($profil_id){
        if(in_array($profil_id,[1,2])){
            dd('ok');
            return redirect('/tableau-de-bord');
        }
    }

    protected function validateLogin()
    {
        request()->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        //    'g-recaptcha-response' => 'required|captcha'
        ]);


    }
/*
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect(env("CENTRALISATION_LINK", "/login"));
    }
*/

    public function logout(){
        if (Auth::check()) Auth::logout();
        request()->session()->remove('2fa_verified');

        return redirect()->route("accueil");
    }
}
