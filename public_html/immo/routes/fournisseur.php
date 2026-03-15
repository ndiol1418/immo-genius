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

// Route::middleware(['auth'])->middleware(['2fa'])->group(function () {

    Route::middleware(['auth', '2fa', 'role:fournisseur|admin'])
            ->prefix("agent")
            ->name("agent.")
            ->group(function () {
                Route::get('/tableau-de-bord', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard.home');

                // Route::resource("biens", App\Http\Controllers\Fournisseur\BiensController::class);

            // immo
            Route::resource("biens", App\Http\Controllers\Fournisseur\BiensController::class);
            Route::resource("immos", App\Http\Controllers\Fournisseur\ImmosController::class);
            Route::resource("annonces", App\Http\Controllers\Fournisseur\AnnoncesController::class);
            Route::resource("users", App\Http\Controllers\Fournisseur\UsersController::class);
            Route::resource("agents", App\Http\Controllers\Fournisseur\FournisseursController::class);
            Route::post('agents/link/{id}',[App\Http\Controllers\Fournisseur\FournisseursController::class,'link'])->name('reseau');
            Route::post('agents/unlink/{id}',[App\Http\Controllers\Fournisseur\FournisseursController::class,'unlink'])->name('unlink');
            Route::get('reseaux',[App\Http\Controllers\Fournisseur\FournisseursController::class,'reseaux'])->name('reseaux.links');


    });
    Route::name('partials.')->group(function () {
        Route::get('/dashboard-cards', [App\Http\Controllers\HomeController::class, 'getCards'])->name('agent.getCards');


    });
// });
