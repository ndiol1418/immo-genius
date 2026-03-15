<?php

namespace App\Http\Middleware;

use App\Models\TmpRequest;
use Closure;
use Illuminate\Http\Request;

class CentralisationAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
        $_token = request('_token');
        if($_token && $this->checkToken($_token)) {
            return $next($request);
        }

        return response()->json(['error' => 'Token expiré, requête non - autorisée !'], 403);
    }

    private function checkToken($token) {
        $token = TmpRequest::where('_token', $token)->first();
        if($token) $token->destroy(); //Remove tmp request
        return $token;
    }
}
