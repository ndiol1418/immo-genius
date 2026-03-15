<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Authentifie un utilisateur et retourne un token Sanctum.
     *
     * POST /api/v1/auth/login
     * Body : { email, password, device_name? }
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email'       => ['required', 'email'],
            'password'    => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        if (! $user->status) {
            return response()->json([
                'message' => "Votre compte est désactivé. Contactez l'administrateur.",
            ], 403);
        }

        // Révocation des tokens précédents du même device pour éviter l'accumulation
        $deviceName = $request->input('device_name', 'mobile');
        $user->tokens()->where('name', $deviceName)->delete();

        $token = $user->createToken($deviceName)->plainTextToken;

        return response()->json([
            'token'      => $token,
            'token_type' => 'Bearer',
            'user'       => [
                'id'         => $user->id,
                'email'      => $user->email,
                'profil'     => $user->profil_name,  // accessor existant
                'is_premium' => (bool) ($user->fournisseur?->is_premium ?? false),
            ],
        ]);
    }

    /**
     * Révoque le token courant (déconnexion).
     *
     * POST /api/v1/auth/logout
     * Header : Authorization: Bearer {token}
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Déconnecté avec succès.']);
    }

    /**
     * Retourne les informations de l'utilisateur authentifié.
     *
     * GET /api/v1/auth/me
     * Header : Authorization: Bearer {token}
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user()->load('fournisseur');

        return response()->json([
            'data' => [
                'id'         => $user->id,
                'email'      => $user->email,
                'profil'     => $user->profil_name,
                'is_premium' => (bool) ($user->fournisseur?->is_premium ?? false),
                'fournisseur_id' => $user->fournisseur?->id,
            ],
        ]);
    }
}
