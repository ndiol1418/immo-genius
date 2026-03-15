<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Commandes, Gérant, Royalties
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', '2fa', 'translate'])->group(function () {

    // Royalties
    Route::any('taux/royalties-fournisseur', [App\Http\Controllers\RoyaltiesController::class, 'fournisseur'])->name('royalties.fournisseur');
    Route::any('taux/royalties-periodique/{id?}', [App\Http\Controllers\RoyaltiesController::class, 'periodique'])->name('royalties.periodique');
    Route::any('taux/royalties-station', [App\Http\Controllers\RoyaltiesController::class, 'station'])->name('royalties.station');

    // Réceptions
    Route::resource('receptions', \App\Http\Controllers\Admin\ReceptionsController::class);
    Route::get('preview-excel/{id}', [\App\Http\Controllers\Admin\ReceptionsController::class, 'preview'])->name('reception.excel');

    // Commandes
    Route::resource("commandes", App\Http\Controllers\CommandesController::class);
    Route::name('commandes.')->prefix('commandes')->group(function () {
        Route::post('storeReception', [\App\Http\Controllers\CommandesController::class, 'storeReception'])->name('storeReception');
        Route::get('{id}/listeReceptions', [\App\Http\Controllers\CommandesController::class, 'listeReceptions'])->name('listeReceptions');
        Route::get('{id}/reception', [\App\Http\Controllers\CommandesController::class, 'reception'])->name('reception');
        Route::any('reception/{id}/receptionDefinitive', [\App\Http\Controllers\CommandesController::class, 'receptionDefinitive'])->name('reception.definitive');
        Route::get('{id}/retour', [\App\Http\Controllers\CommandesController::class, 'retour'])->name('retour');
        Route::get('validees', [\App\Http\Controllers\CommandesController::class, 'validees'])->name('validees');
        Route::get('traitees', [\App\Http\Controllers\CommandesController::class, 'traitees'])->name('traitees');
        Route::get('en_attente', [\App\Http\Controllers\CommandesController::class, 'enAttentes'])->name('en_attente');
        Route::get('brouillons', [\App\Http\Controllers\CommandesController::class, 'brouillons'])->name('brouillons');
        Route::get('confirmees', [\App\Http\Controllers\CommandesController::class, 'confirmees'])->name('confirmees');
        Route::get('annulees', [\App\Http\Controllers\CommandesController::class, 'annulees'])->name('annulees');
        Route::any('commandes/{ref}/soumettre', [App\Http\Controllers\CommandesController::class, 'soumettre'])->name("soumettre");
        Route::any('commandes/{ref}/updateCommande', [App\Http\Controllers\CommandesController::class, 'updateCommande'])->name("updateCommande");
        Route::get('{id}/pdf', [\App\Http\Controllers\Admin\ReceptionsController::class, 'pdf'])->name('receptions.pdf');
        Route::get('commandes/{id}/pdf', [\App\Http\Controllers\CommandesController::class, 'pdf'])->name('commandes.pdf');
        Route::any('{id}/clone', [\App\Http\Controllers\CommandesController::class, 'clone'])->name('clone');
        Route::any('commande-liste/json/{id?}', [App\Http\Controllers\CommandesController::class, 'getCommandes'])->name('jsonCommandes.liste');
    });

    // JSON data endpoints
    Route::get('produit-liste/json', [App\Http\Controllers\Admin\ProduitsController::class, 'getData'])->name('jsonProduits.liste');
    Route::any('fournisseur-liste/json', [App\Http\Controllers\RoyaltiesController::class, 'getDataFournisseurs'])->name('jsonFournisseurs.liste');
    Route::get('station-liste/json', [App\Http\Controllers\Admin\StationsController::class, 'getData'])->name('jsonStations.liste');

    // Partials dashboard
    Route::name('partials.')->group(function () {
        Route::get('/dashboard-cards', [App\Http\Controllers\HomeController::class, 'getCards'])->name('getCards');
        Route::get('/taux_royalties/stations', [App\Http\Controllers\RoyaltiesController::class, 'listeRoyaltieStations'])->name('listeStations');
        Route::any('/card/ca/{debut?}/{fin?}', [App\Http\Controllers\RoyaltiesController::class, 'getCardCA'])->name('card-chiffre');
    });

    // Superviseurs
    Route::name('superviseurs.')->group(function () {
        Route::get('comptes/{id}', [App\Http\Controllers\Admin\ComptesController::class, 'statistiques'])->name('comptes.show');
        Route::get('boutiques/{compte?}', [App\Http\Controllers\Admin\StationsController::class, 'index'])->name('boutiques');
        Route::get('comptes', [App\Http\Controllers\Admin\ComptesController::class, 'index'])->name('comptes');
        Route::get('comptes/{id}/{year?}', [App\Http\Controllers\Admin\ComptesController::class, 'statistiques'])->name('comptes.annuelles');
    });

    // Gérant
    Route::middleware(['role:gerant'])
        ->prefix('gerant')
        ->name('gerant.')
        ->group(function () {
            Route::resource("commandes", App\Http\Controllers\Gerant\CommandesController::class);
            Route::get('commandes-validees', [\App\Http\Controllers\Gerant\CommandesController::class, 'validees'])->name('commandes.validees');
            Route::get('commandes-traitees', [\App\Http\Controllers\Gerant\CommandesController::class, 'traitees'])->name('commandes.traitees');
            Route::get('commandes-confirmees', [\App\Http\Controllers\Gerant\CommandesController::class, 'confirmees'])->name('commandes.confirmees');
            Route::get('commandes-annulees', [\App\Http\Controllers\Gerant\CommandesController::class, 'annulees'])->name('commandes.annulees');
            Route::get('tableau-de-bord', [App\Http\Controllers\Gerant\DashboardController::class, 'index'])->name('dashboard');
            Route::resource("produits", App\Http\Controllers\Gerant\ProduitsController::class);
            Route::get('commandes-en_attente', [\App\Http\Controllers\CommandesController::class, 'enAttentes'])->name('commandes.en_attente');
            Route::get('/promos_encours', [App\Http\Controllers\Admin\PromotionsController::class, 'enCours'])->name('promotions.en_cours');
        });

    // Collaborateurs (à compléter)
    Route::prefix("collaborateurs")
        ->name("collaborateurs.")
        ->group(function () {});
});
