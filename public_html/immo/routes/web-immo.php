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
