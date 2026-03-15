<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(Auth::check()) {
            if(Auth::user()->is_admin || in_array(Auth::user()->role->profil->name,['admin'])) { //Is Administrateur
                return $next($request);

            }
            if(Auth::user()->role->profil->name == 'fournisseur') { //Is Administrateur
                return redirect('agent/tableau-de-bord');
            }
            if(Auth::user()->role->profil->name == 'gerant') { //Is Administrateur
                return redirect()->route('gerant.dashboard');
            }
        }
        return redirect()->route('login');
    }
}
