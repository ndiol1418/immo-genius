<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class TranslateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::check()) {
            return route('login');
        }
        $path = request()->path();
        $lang = explode('/', $path)[0];
        $availables_lang = Config::get('app.availables_lang');
        if (isset($_GET['lang'])) {
            # code...
            App::setLocale($_GET['lang']);

        }
        if(isset($lang)) {
            if(in_array($lang, $availables_lang)) {
                App::setLocale($lang);
            } else {
                // if(!in_array($lang, ['admin', 'university'])) {
                //     abort(404);
                // }
            }
        }
        //Pour generer par defaut le parametre Langue
        // URL::defaults(['langue' => app()->getLocale()]);
        return $next($request);
    }
}
