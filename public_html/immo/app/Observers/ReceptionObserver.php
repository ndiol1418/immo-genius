<?php

namespace App\Observers;

use App\Models\Reception;

class ReceptionObserver
{
    /**
     * Handle the Reception "created" event.
     *
     * @param  \App\Models\Reception  $reception
     * @return void
     */
    public function created(Reception $reception)
    {
        if ($reception->estComplete()) {
            $reception->commande->updateEtat('traité');
        }
    }

    /**
     * Handle the Reception "updated" event.
     *
     * @param  \App\Models\Reception  $reception
     * @return void
     */
    public function updated(Reception $reception)
    {
        //

    }

    /**
     * Handle the Reception "deleted" event.
     *
     * @param  \App\Models\Reception  $reception
     * @return void
     */
    public function deleted(Reception $reception)
    {
        //
    }

    /**
     * Handle the Reception "restored" event.
     *
     * @param  \App\Models\Reception  $reception
     * @return void
     */
    public function restored(Reception $reception)
    {
        //
    }

    /**
     * Handle the Reception "force deleted" event.
     *
     * @param  \App\Models\Reception  $reception
     * @return void
     */
    public function forceDeleted(Reception $reception)
    {
        //
    }
}
