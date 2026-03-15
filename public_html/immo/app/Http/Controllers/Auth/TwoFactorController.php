<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User as ModelsUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Validation\ValidationException;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TwoFactorController extends Controller
{
    //


    public function show(Request $request)
    {
        if(Auth::user()){
            $user = Auth::user();
            $google2fa = new Google2FA();

            $secret = $user->google2fa_secret;
            // $google2fa->setWindow(2);

            $inlineUrl = $google2fa->getQRCodeUrl(
                'TEMS',
                'E-commande',
                $secret
            );

            $inlineUrl = QrCode::size(100)->generate($inlineUrl);
            return view('auth.2fa',compact('secret','inlineUrl','user'));

        }
        return redirect()->route('login');
    }
    public function verify(Request $request)
    {
        $request->validate([
            'otp1' => 'required|numeric',
            'otp2' => 'required|numeric',
            'otp3' => 'required|numeric',
            'otp4' => 'required|numeric',
            'otp5' => 'required|numeric',
            'otp6' => 'required|numeric',
        ]);
        $otp = request('otp1').request('otp2').request('otp3').request('otp4').request('otp5').request('otp6');
        $user_id = $request->session()->get('2fa:user:id');
        $remember = $request->session()->get('2fa:auth:remember', false);
        $attempt = $request->session()->get('2fa:auth:attempt', false);
        if (!$user_id || !$attempt) {
            return redirect()->route('login');
        }

        $user = User::find($user_id);
        if (!$user || !$user->google2fa_secret) {
            return redirect()->route('login');
        }

        $google2fa = new Google2FA();
        // $google2fa->setWindow(2);
        $otp_secret = $user->google2fa_secret;
        // dd($google2fa);
        if (!$google2fa->verifyKey($otp_secret, $otp)) {
            // Auth::logout();
            throw ValidationException::withMessages([
                'otp1' => [__('Le code est incorrect ou expiré. Veuillez renvoyer un nouveau code')],
            ]);
        }
        $guard = config('auth.defaults.guard');

        $credentials = [$user->getAuthIdentifierName() => $user->getAuthIdentifier(), 'password' => $user->getAuthPassword()];
        // dd($credentials);
        if ($remember) {
            $guard = config('auth.defaults.remember_me_guard', $guard);
        }

        if ($attempt) {
            $guard = config('auth.defaults.attempt_guard', $guard);
        }
        session(['2fa_verified' => true]);
        $user->is_scanned = 1;
        $user->save();
        if (Auth::guard($guard)->attempt($credentials, $remember)) {

            $request->session()->remove('2fa:user:id');
            $request->session()->remove('2fa:auth:remember');
            $request->session()->remove('2fa:auth:attempt');

            return redirect()->route('dashboard.home');
        }
        return redirect()->route('login')->withErrors([
            'otp1' => __('The provided credentials are incorrect.'),
        ]);
    }

    public function resendCode(Request $request){
        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();
        $user = Auth::user();
        $user = ModelsUser::find(Auth::id());
        $user->google2fa_secret = $secret;
        $otp_secret = $user->google2fa_secret;
        $code = $google2fa->getCurrentOtp($otp_secret);
        // $user->plateforme_ids = $code;
        session(['2fa_verified' => false]);

        try {
            // User::sendCode2Fa($user,$code);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
        $user->save()?
                flash("Code envoyé avec succès")->success():
                flash("Une erreur est survenue au moment du traitement.")->error();
        return redirect()->back();
    }
}
