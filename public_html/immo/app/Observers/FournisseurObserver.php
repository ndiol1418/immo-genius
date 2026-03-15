<?php

namespace App\Observers;

use App\Models\Fournisseur;

class FournisseurObserver
{
    /**
     * Handle the Fournisseur "created" event.
     *
     * @param  \App\Models\Fournisseur  $fournisseur
     * @return void
     */
    public function created(Fournisseur $fournisseur)
    {
        //
    }

    /**
     * Handle the Fournisseur "updated" event.
     *
     * @param  \App\Models\Fournisseur  $fournisseur
     * @return void
     */
    public function updated(Fournisseur $fournisseur)
    {
        //
        $dirty = $fournisseur->getDirty();
        // dd($dirty);
        if(count($dirty) > 0){
            if(isset($dirty['agents'])){
                if($fournisseur->getOriginal('agents') != null){

                    $agents = $fournisseur->getOriginal('agents')->toArray();
                    try {
                        //code...
                        if(count($agents) <= count($fournisseur->agents->toArray())){

                            $agents  = array_diff(array_merge ($fournisseur->agents->toArray()),$agents);
                            // Send Mail
                        }


                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                }
                // dd('projets en cours');

            }
        }
    }

    /**
     * Handle the Fournisseur "deleted" event.
     *
     * @param  \App\Models\Fournisseur  $fournisseur
     * @return void
     */
    public function deleted(Fournisseur $fournisseur)
    {
        //
    }

    /**
     * Handle the Fournisseur "restored" event.
     *
     * @param  \App\Models\Fournisseur  $fournisseur
     * @return void
     */
    public function restored(Fournisseur $fournisseur)
    {
        //
    }

    /**
     * Handle the Fournisseur "force deleted" event.
     *
     * @param  \App\Models\Fournisseur  $fournisseur
     * @return void
     */
    public function forceDeleted(Fournisseur $fournisseur)
    {
        //
    }
}
