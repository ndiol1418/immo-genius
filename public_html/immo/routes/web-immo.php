<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Immo (annonces, biens, agents, locations)
|--------------------------------------------------------------------------
*/

// Suppression d'image d'annonce
Route::any('/suppression-annonces/images/{id}', [App\Http\Controllers\AccueilController::class, 'destroyImage'])->name('annonce.image.delete');

// Consultation publique
Route::get('/annonces/{id}', [App\Http\Controllers\AccueilController::class, 'annonce'])->name('annonce');
Route::get('/agent/{id}', [App\Http\Controllers\AccueilController::class, 'agentView'])->name('agent.show');
Route::get('/agents', [App\Http\Controllers\AccueilController::class, 'agents'])->name('agents');
Route::post('/agents-search', [App\Http\Controllers\SearchController::class, 'agentSearch'])->name('agent.search');

// Publication et modification d'annonces
Route::post('/publier', [App\Http\Controllers\AccueilController::class, 'publierAnnonce'])->name('annonce.store');
Route::post('/annonces/update/{annonce}', [App\Http\Controllers\AccueilController::class, 'modifierAnnonce'])->name('modifier-annonce.update');

// Recherche d'annonces
Route::post('/search', [App\Http\Controllers\SearchController::class, 'search'])->name('annonce.search');
Route::post('/search-more', [App\Http\Controllers\SearchController::class, 'searchMore'])->name('annonce.searchMore');

// Favoris
Route::middleware(['auth'])->group(function () {
    Route::post('/favoris/toggle/{annonce_id}', [App\Http\Controllers\FavorisController::class, 'toggle'])->name('favoris.toggle');
    Route::get('/mes-favoris', [App\Http\Controllers\FavorisController::class, 'index'])->name('favoris.index');
});

// Messagerie
Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [App\Http\Controllers\MessagesController::class, 'index'])->name('messages.index');
    Route::get('/messages/{conversation}', [App\Http\Controllers\MessagesController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}', [App\Http\Controllers\MessagesController::class, 'store'])->name('messages.store');
    Route::post('/contact/{annonce_id}', [App\Http\Controllers\MessagesController::class, 'contact'])->name('messages.contact');
});

// Alertes
Route::middleware(['auth'])->group(function () {
    Route::get('/mes-alertes', [App\Http\Controllers\AlertesController::class, 'index'])->name('alertes.index');
    Route::post('/alertes', [App\Http\Controllers\AlertesController::class, 'store'])->name('alertes.store');
    Route::delete('/alertes/{alerte}', [App\Http\Controllers\AlertesController::class, 'destroy'])->name('alertes.destroy');
    Route::post('/alertes/{alerte}/toggle', [App\Http\Controllers\AlertesController::class, 'toggle'])->name('alertes.toggle');
});

// Avis
Route::post('/avis', [App\Http\Controllers\AvisController::class, 'store'])->name('avis.store');

// Comparaison
Route::get('/comparer', [App\Http\Controllers\ComparaisonController::class, 'index'])->name('comparer');

// Calculateur de prêt
Route::get('/calculateur-pret', [App\Http\Controllers\CalculateurController::class, 'index'])->name('calculateur');

// Estimation de bien
Route::get('/estimation', [App\Http\Controllers\EstimationController::class, 'index'])->name('estimation');
Route::post('/estimation', [App\Http\Controllers\EstimationController::class, 'estimer'])->name('estimation.estimer');

// Analytics agent
Route::middleware(['auth'])->group(function () {
    Route::get('/agent/analytics', [App\Http\Controllers\AnalyticsController::class, 'index'])->name('agent.analytics');
});

// Géolocalisation — annonces près de moi
Route::post('/annonces/near-me', [App\Http\Controllers\SearchController::class, 'nearMe'])->name('annonces.nearMe');

// Recherche IA — langage naturel
Route::post('/recherche-ia', [App\Http\Controllers\SearchController::class, 'aiSearch'])->name('recherche.ia');
Route::get('/recherche-ia/suggestions', [App\Http\Controllers\SearchController::class, 'recherchesSuggestions'])->name('recherche.ia.suggestions');

// Gestion Locative
Route::middleware(['auth'])->group(function () {
    Route::get('/gestion-locative', [App\Http\Controllers\GestionLocativeController::class, 'index'])->name('gestion-locative.index');
    Route::get('/gestion-locative/creer', [App\Http\Controllers\GestionLocativeController::class, 'create'])->name('gestion-locative.create');
    Route::post('/gestion-locative', [App\Http\Controllers\GestionLocativeController::class, 'store'])->name('gestion-locative.store');
    Route::get('/gestion-locative/{contrat}', [App\Http\Controllers\GestionLocativeController::class, 'show'])->name('gestion-locative.show');
    Route::post('/gestion-locative/{contrat}/paiement', [App\Http\Controllers\GestionLocativeController::class, 'enregistrerPaiement'])->name('gestion-locative.paiement');
    Route::get('/gestion-locative/{contrat}/quittance/{mois}', [App\Http\Controllers\GestionLocativeController::class, 'quittancePdf'])->name('gestion-locative.quittance');
    Route::post('/gestion-locative/{contrat}/signer', [App\Http\Controllers\GestionLocativeController::class, 'signer'])->name('gestion-locative.signer');
    Route::get('/gestion-locative/{contrat}/pdf', [App\Http\Controllers\GestionLocativeController::class, 'contratPdf'])->name('gestion-locative.pdf');
});
