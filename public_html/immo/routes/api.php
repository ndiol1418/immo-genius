<?php

use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::prefix('users')->name('centralisation.')->group(function() {
    Route::middleware('centralisation_auth')->group(function() {
        Route::post('login.json', [App\Http\Controllers\ApiCentralisationController::class, 'login']);
        Route::post('update.json', [App\Http\Controllers\ApiCentralisationController::class, 'update']);
        Route::post('connexionPlateforme.json', [App\Http\Controllers\ApiCentralisationController::class, 'connexionPlateforme']);
        Route::post('getProfiles.json', [App\Http\Controllers\ApiCentralisationController::class, 'getProfiles']);

    });
    Route::post('authorizeRequest.json', [App\Http\Controllers\ApiCentralisationController::class, 'authorizeRequest']);
});