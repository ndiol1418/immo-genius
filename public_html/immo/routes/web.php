<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Routes publiques de base
|--------------------------------------------------------------------------
*/

Route::get('/connexion', function () {
    return redirect("/login");
});

// Socialite
Route::get("login-register", [App\Http\Controllers\SocialiteController::class, 'loginRegister']);
Route::get("redirect/{provider}", [App\Http\Controllers\SocialiteController::class, 'redirect'])->name('socialite.redirect');
Route::get("callback/{provider}", [App\Http\Controllers\SocialiteController::class, 'callback'])->name('socialite.callback');

// Pages publiques
Route::get('/', [App\Http\Controllers\AccueilController::class, 'accueil'])->name('accueil');
Route::get('/acheter', [App\Http\Controllers\AccueilController::class, 'acheter'])->name('acheter');
Route::get('/louer', [App\Http\Controllers\AccueilController::class, 'louer'])->name('louer');
Route::get('/cgu', [App\Http\Controllers\AccueilController::class, 'cgu'])->name('cgu');
Route::get('/faq', [App\Http\Controllers\AccueilController::class, 'faq'])->name('faq');

// Blog
Route::get('/blog', [App\Http\Controllers\ArticleController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [App\Http\Controllers\ArticleController::class, 'show'])->name('blog.show');
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/blog', [App\Http\Controllers\ArticleController::class, 'adminIndex'])->name('blog.admin.index');
    Route::get('/admin/blog/creer', [App\Http\Controllers\ArticleController::class, 'create'])->name('blog.create');
    Route::post('/admin/blog', [App\Http\Controllers\ArticleController::class, 'store'])->name('blog.store');
    Route::get('/admin/blog/{id}/editer', [App\Http\Controllers\ArticleController::class, 'edit'])->name('blog.edit');
    Route::put('/admin/blog/{id}', [App\Http\Controllers\ArticleController::class, 'update'])->name('blog.update');
    Route::post('/admin/blog/{id}/toggle', [App\Http\Controllers\ArticleController::class, 'toggleStatut'])->name('blog.toggle');
});

// Marché immobilier
Route::get('/marche-immobilier', [App\Http\Controllers\MarcheController::class, 'index'])->name('marche.index');
Route::get('/marche-immobilier/pdf', [App\Http\Controllers\MarcheController::class, 'pdf'])->name('marche.pdf');

// Guides
Route::get('/guide-acheteur', fn() => view('guide.acheteur'))->name('guide.acheteur');
Route::get('/guide-vendeur', fn() => view('guide.vendeur'))->name('guide.vendeur');

// Inscription
Route::get('/inscriptions', [App\Http\Controllers\AccueilController::class, 'inscriptionFormShow'])->name('inscriptions');
Route::post('/inscriptions/create', [App\Http\Controllers\AccueilController::class, 'inscrire'])->name('inscriptions.create');

// Auth
Route::post('/login', 'Auth\LoginController@login')->middleware('throttle:5,1');
Auth::routes(['register' => false]);

Route::resource("commentaires", App\Http\Controllers\CommentairesController::class);
Route::resource("users", App\Http\Controllers\UsersController::class);

// 2FA
Route::get('/2fa', [App\Http\Controllers\Auth\TwoFactorController::class, 'show'])->middleware('auth')->name('2fa');
Route::post('/2fa', [App\Http\Controllers\Auth\TwoFactorController::class, 'verify'])->name('2fa.verify');

// Lien de visualisation commande (token public)
Route::get('/confirmation-commande/{token}', [\App\Http\Controllers\HomeController::class, 'link'])->name('commandes.visualisation');

// Routes authentifiées de base
Route::middleware(['auth', '2fa', 'translate'])->group(function () {
    Route::get('/tableau-de-bord', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard.home');
    Route::get('/compte', function () {
        return view("users.profile");
    })->name('compte');
    Route::any('/2fa/resend', [App\Http\Controllers\Auth\TwoFactorController::class, 'resendCode'])->name('2fa.resendCode');
    Route::get('/recherche', [App\Http\Controllers\SearchController::class, 'search'])->name('search');
});
