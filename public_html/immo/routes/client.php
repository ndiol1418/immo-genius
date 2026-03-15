<?php

use App\Models\ChaineValidation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['gerant_middleware'])
->prefix("client")
->name("client.")
->group(function () {
    Route::get('/tableau-de-bord', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard.home');

    // Route::resource("biens", App\Http\Controllers\Fournisseur\BiensController::class);

    // immo
    Route::resource("biens", App\Http\Controllers\Admin\BiensController::class);
    Route::resource("annonces", App\Http\Controllers\Admin\AnnoncesController::class);

});
Route::name('partials.')->group(function () {
Route::get('/dashboard-cards', [App\Http\Controllers\HomeController::class, 'getCards'])->name('client.getCards');

});
