<?php

use App\Mail\EmailNotification;
use App\Models\Commande;
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

Route::get('/connexion', function () {
    return redirect("/login");
});
# Socialite URLs

// La page où on présente les liens de redirection vers les providers
Route::get("login-register", [App\Http\Controllers\SocialiteController::class,'loginRegister']);

// La redirection vers le provider
Route::get("redirect/{provider}", [App\Http\Controllers\SocialiteController::class,'redirect'])->name('socialite.redirect');

// Le callback du provider
Route::get("callback/{provider}", [App\Http\Controllers\SocialiteController::class,'callback'])->name('socialite.callback');
Route::any('/suppression-annonces/images/{id}', [App\Http\Controllers\AccueilController::class, 'destroyImage'])->name('annonce.image.delete');

Route::get('/', [App\Http\Controllers\AccueilController::class,'accueil'])->name('accueil');
Route::get('/acheter', [App\Http\Controllers\AccueilController::class,'acheter'])->name('acheter');
Route::get('/louer', [App\Http\Controllers\AccueilController::class,'louer'])->name('louer');
Route::get('/cgu', [App\Http\Controllers\AccueilController::class,'cgu'])->name('cgu');
Route::get('/faq', [App\Http\Controllers\AccueilController::class,'faq'])->name('faq');
Route::get('/agent/{id}', [App\Http\Controllers\AccueilController::class,'agentView'])->name('agent.show');
Route::get('/annonces/{id}', [App\Http\Controllers\AccueilController::class,'annonce'])->name('annonce');
Route::get('/agents', [App\Http\Controllers\AccueilController::class,'agents'])->name('agents');
Route::post('/agents-search', [App\Http\Controllers\SearchController::class,'agentSearch'])->name('agent.search');
Route::get('/inscriptions', [App\Http\Controllers\AccueilController::class,'inscriptionFormShow'])->name('inscriptions');
Route::post('/inscriptions/create', [App\Http\Controllers\AccueilController::class,'inscrire'])->name('inscriptions.create');
Route::post('/login', 'Auth\LoginController@login')->middleware('throttle:5,1');
// Route::middleware('centralisation_auth')->any('loginRedirectFromCentral.json', [App\Http\Controllers\ApiCentralisationController::class, 'loginRedirectFromCentral'])->name('centralisation.redirect');
Auth::routes(['register' => false]);
Route::post('/publier', [App\Http\Controllers\AccueilController::class, 'publierAnnonce'])->name('annonce.store');
Route::post('/search', [App\Http\Controllers\SearchController::class, 'search'])->name('annonce.search');
Route::post('/search-more', [App\Http\Controllers\SearchController::class, 'searchMore'])->name('annonce.searchMore');
Route::post('/annonces/update/{annonce}', [App\Http\Controllers\AccueilController::class, 'modifierAnnonce'])->name('modifier-annonce.update');
Route::resource("commentaires", App\Http\Controllers\CommentairesController::class);


Route::resource("users", App\Http\Controllers\UsersController::class);
Route::get('/mailable', function () {
    $invoice = Commande::find(74802);
    $station = $invoice->station->nom;
    // dd($station);
    $msg = "<br>Une commande vous a été adressée par la station ".$invoice->station->nom.".";
    $msg .= "<br>Vous avez en pièce jointe le bon de commande";
    // $msg .= "<br><br>Veuillez cliquer sur le lien ci-dessous pour confirmer cette commande:<br>";
    $complement_subject = "Demande de confirmation de la commande n° $invoice->ref de la station $station.";

    return new EmailNotification('Confirmation de commande',$msg,'ABS',$invoice);
});
Route::get('/confirmation-commande/{token}', [\App\Http\Controllers\HomeController::class, 'link'])->name('commandes.visualisation');
Route::get('/2fa', [App\Http\Controllers\Auth\TwoFactorController::class,'show'])->middleware('auth')->name('2fa');
Route::post('/2fa', [App\Http\Controllers\Auth\TwoFactorController::class,'verify'])->name('2fa.verify');
Route::middleware(['auth'])->middleware(['2fa','translate'])->group(function () {
    Route::get('/tableau-de-bord', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard.home');
    Route::get('/compte', function () {
        return view("users.profile");
    })->name('compte');
    Route::any('taux/royalties-fournisseur', [App\Http\Controllers\RoyaltiesController::class, 'fournisseur'])->name('royalties.fournisseur');
    Route::any('taux/royalties-periodique/{id?}', [App\Http\Controllers\RoyaltiesController::class, 'periodique'])->name('royalties.periodique');
    Route::any('taux/royalties-station', [App\Http\Controllers\RoyaltiesController::class, 'station'])->name('royalties.station');
    Route::any('/2fa/resend', [App\Http\Controllers\Auth\TwoFactorController::class,'resendCode'])->name('2fa.resendCode');
    Route::resource('receptions',\App\Http\Controllers\Admin\ReceptionsController::class);
    Route::get('preview-excel/{id}',[\App\Http\Controllers\Admin\ReceptionsController::class,'preview'])->name('reception.excel');
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
        Route::get('traitees', [\App\Http\Controllers\CommandesController::class, 'traitees'])->name('traitees');
        Route::get('annulees', [\App\Http\Controllers\CommandesController::class, 'annulees'])->name('annulees');
        Route::any('commandes/{ref}/soumettre', [App\Http\Controllers\CommandesController::class, 'soumettre'])->name("soumettre");
        Route::any('commandes/{ref}/updateCommande', [App\Http\Controllers\CommandesController::class, 'updateCommande'])->name("updateCommande");
        Route::get('{id}/pdf', [\App\Http\Controllers\Admin\ReceptionsController::class, 'pdf'])->name('receptions.pdf');
        Route::get('commandes/{id}/pdf', [\App\Http\Controllers\CommandesController::class, 'pdf'])->name('commandes.pdf');
        Route::any('{id}/clone', [\App\Http\Controllers\CommandesController::class, 'clone'])->name('clone');
        Route::any('commande-liste/json/{id?}', [App\Http\Controllers\CommandesController::class, 'getCommandes'])->name('jsonCommandes.liste');

    });

    Route::get('produit-liste/json', [App\Http\Controllers\Admin\ProduitsController::class, 'getData'])->name('jsonProduits.liste');
    Route::any('fournisseur-liste/json', [App\Http\Controllers\RoyaltiesController::class, 'getDataFournisseurs'])->name('jsonFournisseurs.liste');
    Route::get('station-liste/json', [App\Http\Controllers\Admin\StationsController::class, 'getData'])->name('jsonStations.liste');

    Route::get('/recherche', [App\Http\Controllers\SearchController::class, 'search'])->name('search');
    Route::resource("commandes", App\Http\Controllers\CommandesController::class);

    Route::name('partials.')->group(function () {
        Route::get('/dashboard-cards', [App\Http\Controllers\HomeController::class, 'getCards'])->name('getCards');
        Route::get('/taux_royalties/stations', [App\Http\Controllers\RoyaltiesController::class, 'listeRoyaltieStations'])->name('listeStations');
        Route::any('/card/ca/{debut?}/{fin?}', [App\Http\Controllers\RoyaltiesController::class, 'getCardCA'])->name('card-chiffre');
    });
    Route::name('superviseurs.')->group(function () {
        Route::get('comptes/{id}', [App\Http\Controllers\Admin\ComptesController::class, 'statistiques'])->name('comptes.show');
        Route::get('boutiques/{compte?}', [App\Http\Controllers\Admin\StationsController::class, 'index'])->name('boutiques');
        Route::get('comptes', [App\Http\Controllers\Admin\ComptesController::class, 'index'])->name('comptes');
        Route::get('comptes/{id}/{year?}', [App\Http\Controllers\Admin\ComptesController::class, 'statistiques'])->name('comptes.annuelles');
    });
    Route::middleware(['admin_middleware'])
        ->prefix("admin")
        ->name("admin.")
        ->group(function () {
            Route::get('/tableau-de-bord', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard.home');
            Route::get('produit-liste/json', [App\Http\Controllers\Admin\ProduitsController::class, 'getData'])->name('jsonProduits.liste');
            Route::any('fournisseur-liste/json', [App\Http\Controllers\RoyaltiesController::class, 'getDataFournisseurs'])->name('jsonFournisseurs.liste');
            Route::get('station-liste/json', [App\Http\Controllers\Admin\StationsController::class, 'getData'])->name('jsonStations.liste');

            Route::get('users', [App\Http\Controllers\UsersController::class, 'index'])->name('listUsers');
            Route::post('/users/importUsersCsv', [App\Http\Controllers\UsersController::class, 'importUsersCsv'])->name('importUsersCsv');

            Route::post('/fournisseurs/importCsv', [App\Http\Controllers\Admin\FournisseursController::class, 'importCsv'])->name('importCsv');
            Route::post('/produits/importProduit', [App\Http\Controllers\Admin\ProduitsController::class, 'importProduits'])->name('produits.importProduits');
            Route::get('superviseurs', [App\Http\Controllers\UsersController::class, 'superviseurs'])->name('users.superviseurs');
            Route::get('users/{user}/profil', [App\Http\Controllers\UsersController::class, 'show'])->name('showUser');
            Route::get('actions', [App\Http\Controllers\Admin\ActionsController::class, 'index'])->name("actions.index");
            Route::get('directions', [App\Http\Controllers\Admin\DirectionsController::class, 'index'])->name("directions.index");
            Route::resource("directions", App\Http\Controllers\Admin\DirectionsController::class);
            Route::resource("produits", App\Http\Controllers\Admin\ProduitsController::class);
            Route::resource("zones", App\Http\Controllers\Admin\ZonesController::class);
            Route::resource("familles", App\Http\Controllers\Admin\FamillesController::class);
            Route::resource("sous-familles", App\Http\Controllers\Admin\SousFamillesController::class);
            Route::resource("agents", App\Http\Controllers\Admin\FournisseursController::class);
            Route::resource("departements", App\Http\Controllers\Admin\DepartementsController::class);
            Route::resource("stations", App\Http\Controllers\Admin\StationsController::class);
            Route::resource("gammes", App\Http\Controllers\Admin\GammesController::class);
            Route::resource("promotions", App\Http\Controllers\Admin\PromotionsController::class);
            Route::resource("services", App\Http\Controllers\Admin\ServicesController::class);
            Route::resource("users", App\Http\Controllers\UsersController::class);
            Route::resource("postes", App\Http\Controllers\Admin\PostesController::class);
            Route::resource("comptes", App\Http\Controllers\Admin\ComptesController::class);
            Route::resource("listes", App\Http\Controllers\Admin\ListesController::class);
            Route::resource("delais-de-livraisons", App\Http\Controllers\Admin\DessertesController::class);

            Route::post('users/regenererCode/{id}',[App\Http\Controllers\UsersController::class,'regenererQrCode'])->name('qrCode');

            // immo
            Route::resource("biens", App\Http\Controllers\Admin\BiensController::class);
            Route::resource("type_locations", App\Http\Controllers\Admin\TypeLocationsContoller::class);
            Route::resource("type_biens", App\Http\Controllers\Admin\TypeBiensController::class);
            Route::resource("type_immos", App\Http\Controllers\Admin\TypeImmosController::class);
            Route::resource("immos", App\Http\Controllers\Admin\ImmosController::class);
            Route::resource("types", App\Http\Controllers\Admin\TypesController::class);
            Route::resource("communes", App\Http\Controllers\Admin\CommunesController::class);
            Route::resource("departements", App\Http\Controllers\Admin\DepartementsController::class);
            Route::resource("agents", App\Http\Controllers\Admin\FournisseursController::class);
            Route::resource("clients", App\Http\Controllers\Admin\ClientsController::class);
            Route::resource("locations", App\Http\Controllers\Admin\LocationsController::class);
            Route::resource("annonces", App\Http\Controllers\Admin\AnnoncesController::class);
            Route::resource("fournisseurs", App\Http\Controllers\Admin\FournisseursController::class);

            Route::post('store', [App\Http\Controllers\InscriptionsController::class, 'inscrire'])->name('inscriptions.inscrire');
            Route::get('clients-inscrits', [App\Http\Controllers\InscriptionsController::class, 'clients'])->name('inscriptions.clients');
            Route::get('agents-inscrits', [App\Http\Controllers\InscriptionsController::class, 'clients'])->name('inscriptions.agents');

            Route::get('annonce/en_attente', [\App\Http\Controllers\Admin\AnnoncesController::class, 'enAttente'])->name('annonce.en_attente');
            Route::get('annonce/supprimes', [\App\Http\Controllers\Admin\AnnoncesController::class, 'supprimes'])->name('annonce.supprimes');
            Route::post('annonce/validate/{id}', [\App\Http\Controllers\Admin\AnnoncesController::class, 'valideAnnonce'])->name('annonce.validate');


        });

    // Route::middleware(['fournisseur_middleware'])
    //     ->prefix("fournisseur")
    //     ->name("fournisseur.")
    //     ->group(function () {
    //         Route::resource("commandes", App\Http\Controllers\Fournisseur\CommandesController::class);
    //         Route::get('commandes-validees', [\App\Http\Controllers\Fournisseur\CommandesController::class, 'validees'])->name('commandes.validees');
    //         Route::get('commandes-traitees', [\App\Http\Controllers\Fournisseur\CommandesController::class, 'traitees'])->name('commandes.traitees');
    //         Route::get('commandes-confirmees', [\App\Http\Controllers\Fournisseur\CommandesController::class, 'confirmees'])->name('commandes.confirmees');
    //         Route::get('commandes-traitees', [\App\Http\Controllers\Fournisseur\CommandesController::class, 'traitees'])->name('commandes.traitees');
    //         Route::get('commandes-annulees', [\App\Http\Controllers\Fournisseur\CommandesController::class, 'annulees'])->name('commandes.annulees');
    //         Route::get('tableau-de-bord', [App\Http\Controllers\Fournisseur\DashboardController::class, 'index'])->name('dashboard');

    //     });

    Route::middleware(['gerant_middleware'])
        ->prefix("gerant")
        ->name("gerant.")
        ->group(function () {
            Route::resource("commandes", App\Http\Controllers\Gerant\CommandesController::class);
            Route::get('commandes-validees', [\App\Http\Controllers\Gerant\CommandesController::class, 'validees'])->name('commandes.validees');
            Route::get('commandes-traitees', [\App\Http\Controllers\Gerant\CommandesController::class, 'traitees'])->name('commandes.traitees');
            Route::get('commandes-confirmees', [\App\Http\Controllers\Gerant\CommandesController::class, 'confirmees'])->name('commandes.confirmees');
            Route::get('commandes-traitees', [\App\Http\Controllers\Gerant\CommandesController::class, 'traitees'])->name('commandes.traitees');
            Route::get('commandes-annulees', [\App\Http\Controllers\Gerant\CommandesController::class, 'annulees'])->name('commandes.annulees');
            Route::get('tableau-de-bord', [App\Http\Controllers\Gerant\DashboardController::class, 'index'])->name('dashboard');
            Route::resource("produits", App\Http\Controllers\Gerant\ProduitsController::class);
            Route::get('commandes-en_attente', [\App\Http\Controllers\CommandesController::class, 'enAttentes'])->name('commandes.en_attente');
            Route::get('/promos_encours',[App\Http\Controllers\Admin\PromotionsController::class,'enCours'])->name('promotions.en_cours');

        });

    Route::prefix("collaborateurs")
        ->name("collaborateurs.")
        ->group(function () { });

    // Route::prefix('admin')
    //     ->name('admin.')
    //     ->group(function () {
    //         Route::resource('produits', App\Http\Controllers\Admin\ProduitsController::class);
    //         Route::put('/produits/{id}/toggle', [App\Http\Controllers\Admin\ProduitsController::class, 'toggleStatus'])->name('produits.toggle');
    //         Route::resource('promotions', App\Http\Controllers\Admin\PromotionsController::class);
    //         Route::get('/promos_encours',[App\Http\Controllers\Admin\PromotionsController::class,'enCours'])->name('promotions.en_cours');
    //         Route::get('/promos_terminees',[App\Http\Controllers\Admin\PromotionsController::class,'terminees'])->name('promotions.terminees');
    //         Route::any('/suppression_produit_enpromo',[App\Http\Controllers\Admin\PromotionsController::class,'supprimerProduitEnPromo'])->name('promotions.suppression_produit_enpromo');
    //     });

});
