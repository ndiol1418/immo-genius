<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Administration
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', '2fa', 'translate', 'admin_middleware'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/tableau-de-bord', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard.home');

        // JSON data endpoints
        Route::get('produit-liste/json', [App\Http\Controllers\Admin\ProduitsController::class, 'getData'])->name('jsonProduits.liste');
        Route::any('fournisseur-liste/json', [App\Http\Controllers\RoyaltiesController::class, 'getDataFournisseurs'])->name('jsonFournisseurs.liste');
        Route::get('station-liste/json', [App\Http\Controllers\Admin\StationsController::class, 'getData'])->name('jsonStations.liste');

        // Utilisateurs
        Route::get('users', [App\Http\Controllers\UsersController::class, 'index'])->name('listUsers');
        Route::post('/users/importUsersCsv', [App\Http\Controllers\UsersController::class, 'importUsersCsv'])->name('importUsersCsv');
        Route::get('superviseurs', [App\Http\Controllers\UsersController::class, 'superviseurs'])->name('users.superviseurs');
        Route::get('users/{user}/profil', [App\Http\Controllers\UsersController::class, 'show'])->name('showUser');
        Route::post('users/regenererCode/{id}', [App\Http\Controllers\UsersController::class, 'regenererQrCode'])->name('qrCode');
        Route::resource("users", App\Http\Controllers\UsersController::class);

        // Import CSV
        Route::post('/fournisseurs/importCsv', [App\Http\Controllers\Admin\FournisseursController::class, 'importCsv'])->name('importCsv');
        Route::post('/produits/importProduit', [App\Http\Controllers\Admin\ProduitsController::class, 'importProduits'])->name('produits.importProduits');

        // Actions & directions
        Route::get('actions', [App\Http\Controllers\Admin\ActionsController::class, 'index'])->name("actions.index");

        // Resources générales
        Route::resource("directions", App\Http\Controllers\Admin\DirectionsController::class);
        Route::resource("produits", App\Http\Controllers\Admin\ProduitsController::class);
        Route::resource("zones", App\Http\Controllers\Admin\ZonesController::class);
        Route::resource("familles", App\Http\Controllers\Admin\FamillesController::class);
        Route::resource("sous-familles", App\Http\Controllers\Admin\SousFamillesController::class);
        Route::resource("departements", App\Http\Controllers\Admin\DepartementsController::class);
        Route::resource("stations", App\Http\Controllers\Admin\StationsController::class);
        Route::resource("gammes", App\Http\Controllers\Admin\GammesController::class);
        Route::resource("promotions", App\Http\Controllers\Admin\PromotionsController::class);
        Route::resource("services", App\Http\Controllers\Admin\ServicesController::class);
        Route::resource("postes", App\Http\Controllers\Admin\PostesController::class);
        Route::resource("comptes", App\Http\Controllers\Admin\ComptesController::class);
        Route::resource("listes", App\Http\Controllers\Admin\ListesController::class);
        Route::resource("delais-de-livraisons", App\Http\Controllers\Admin\DessertesController::class);
        Route::resource("fournisseurs", App\Http\Controllers\Admin\FournisseursController::class);
        Route::resource("agents", App\Http\Controllers\Admin\FournisseursController::class);

        // Inscriptions
        Route::post('store', [App\Http\Controllers\InscriptionsController::class, 'inscrire'])->name('inscriptions.inscrire');
        Route::get('clients-inscrits', [App\Http\Controllers\InscriptionsController::class, 'clients'])->name('inscriptions.clients');
        Route::get('agents-inscrits', [App\Http\Controllers\InscriptionsController::class, 'clients'])->name('inscriptions.agents');

        // Immo — biens, types, communes, annonces, locations, clients
        Route::resource("biens", App\Http\Controllers\Admin\BiensController::class);
        Route::resource("type_locations", App\Http\Controllers\Admin\TypeLocationsContoller::class);
        Route::resource("type_biens", App\Http\Controllers\Admin\TypeBiensController::class);
        Route::resource("type_immos", App\Http\Controllers\Admin\TypeImmosController::class);
        Route::resource("immos", App\Http\Controllers\Admin\ImmosController::class);
        Route::resource("types", App\Http\Controllers\Admin\TypesController::class);
        Route::resource("communes", App\Http\Controllers\Admin\CommunesController::class);
        Route::resource("clients", App\Http\Controllers\Admin\ClientsController::class);
        Route::resource("locations", App\Http\Controllers\Admin\LocationsController::class);
        Route::resource("annonces", App\Http\Controllers\Admin\AnnoncesController::class);

        // Modération des annonces
        Route::get('annonce/en_attente', [\App\Http\Controllers\Admin\AnnoncesController::class, 'enAttente'])->name('annonce.en_attente');
        Route::get('annonce/supprimes', [\App\Http\Controllers\Admin\AnnoncesController::class, 'supprimes'])->name('annonce.supprimes');
        Route::post('annonce/validate/{id}', [\App\Http\Controllers\Admin\AnnoncesController::class, 'valideAnnonce'])->name('annonce.validate');
    });
