<?php

namespace App\Observers;

use App\Events\MailEvent;
use App\Http\Controllers\UtilitiesController;
use App\Models\Commande;
use App\Models\Fournisseur;
use Illuminate\Support\Facades\App;

class CommandeObserver
{
    /**
     * Handle the Commande "created" event.
     *
     * @param  \App\Models\Commande  $commande
     * @return void
     */
    public function created(Commande $commande)
    {
        //
        $fournisseur = Fournisseur::find($commande->fournisseur_id);
        $commande->taux_royalties = $fournisseur->taux_royalties;
        $commande->token = UtilitiesController::_token(100);
        $commande->save();
    }

    /**
     * Handle the Commande "updated" event.
     *
     * @param  \App\Models\Commande  $commande
     * @return void
     */
    public function updated(Commande $commande)
    {
        //
        if ($commande->etat == 'validé') {
            # code...
            if($commande->token == null ){
                $commande->token = UtilitiesController::_token(100);
                $commande->save();
            }

        }
        if ($commande->estInComplete()) {
            $commande->updateEtat('confirmé');
        }
    }

    /**
     * Handle the Commande "deleted" event.
     *
     * @param  \App\Models\Commande  $commande
     * @return void
     */
    public function deleted(Commande $commande)
    {
        //
    }

    /**
     * Handle the Commande "restored" event.
     *
     * @param  \App\Models\Commande  $commande
     * @return void
     */
    public function restored(Commande $commande)
    {
        //
    }

    /**
     * Handle the Commande "force deleted" event.
     *
     * @param  \App\Models\Commande  $commande
     * @return void
     */
    public function forceDeleted(Commande $commande)
    {
        //
    }
}
