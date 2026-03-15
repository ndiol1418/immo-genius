<?php

use App\Http\Controllers\Api\AgentController;
use App\Http\Controllers\Api\AnnonceController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// ── Mobile API v1 ──────────────────────────────────────────────────────────
Route::prefix('v1')->name('api.v1.')->group(function () {

    // Auth (publique)
    Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');

    // Annonces publiques (lecture seule sans authentification)
    Route::get('annonces',       [AnnonceController::class, 'index'])->name('annonces.index');
    Route::get('annonces/{id}',  [AnnonceController::class, 'show'])->name('annonces.show');
    Route::post('search',        [AnnonceController::class, 'search'])->name('annonces.search');

    // Agents publics (lecture seule sans authentification)
    Route::get('agents',        [AgentController::class, 'index'])->name('agents.index');
    Route::get('agents/{id}',   [AgentController::class, 'show'])->name('agents.show');

    // Routes protégées par Sanctum
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::get('auth/me',      [AuthController::class, 'me'])->name('auth.me');
    });
});

// ── Ancienne API de centralisation ────────────────────────────────────────
Route::prefix('users')->name('centralisation.')->group(function() {
    Route::middleware('centralisation_auth')->group(function() {
        Route::post('login.json', [App\Http\Controllers\ApiCentralisationController::class, 'login']);
        Route::post('update.json', [App\Http\Controllers\ApiCentralisationController::class, 'update']);
        Route::post('connexionPlateforme.json', [App\Http\Controllers\ApiCentralisationController::class, 'connexionPlateforme']);
        Route::post('getProfiles.json', [App\Http\Controllers\ApiCentralisationController::class, 'getProfiles']);

    });
    Route::post('authorizeRequest.json', [App\Http\Controllers\ApiCentralisationController::class, 'authorizeRequest']);
});