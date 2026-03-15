<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

/*
 * Canal par défaut pour les notifications Laravel (toBroadcast).
 * Laravel envoie automatiquement les notifications sur ce canal.
 */
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

/*
 * Canal partagé admin : accessible uniquement aux utilisateurs ayant le rôle 'admin'.
 * Utilisé par l'event AnnonceSubmitted.
 */
Broadcast::channel('admin-notifications', function ($user) {
    return $user->hasRole('admin');
});

/*
 * Canal privé par agent/fournisseur.
 * Utilisé par AnnonceValidated et NewComment.
 * L'utilisateur doit être le propriétaire du compte fournisseur.
 */
Broadcast::channel('agent.{fournisseurId}', function ($user, int $fournisseurId) {
    return (int) ($user->fournisseur?->id) === $fournisseurId;
});
