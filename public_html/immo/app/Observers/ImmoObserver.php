<?php

namespace App\Observers;

use App\Models\Immo;

class ImmoObserver
{
    /**
     * Handle the Immo "created" event.
     *
     * @param  \App\Models\Immo  $immo
     * @return void
     */
    public function created(Immo $immo)
    {
        //
    }

    /**
     * Handle the Immo "updated" event.
     *
     * @param  \App\Models\Immo  $immo
     * @return void
     */
    public function updated(Immo $immo)
    {
        //
        $dirty = $immo->getDirty();
        if(count($dirty) > 0){
            if(isset($dirty['agents'])){
                if($immo->getOriginal('agents') != null){

                    $agents = $immo->getOriginal('agents')->toArray();
                    try {
                        //code...
                        if(count($agents) <= count($immo->agents->toArray())){

                            $agents  = array_diff(array_merge ($immo->agents->toArray()),$agents);
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
     * Handle the Immo "deleted" event.
     *
     * @param  \App\Models\Immo  $immo
     * @return void
     */
    public function deleted(Immo $immo)
    {
        //
    }

    /**
     * Handle the Immo "restored" event.
     *
     * @param  \App\Models\Immo  $immo
     * @return void
     */
    public function restored(Immo $immo)
    {
        //
    }

    /**
     * Handle the Immo "force deleted" event.
     *
     * @param  \App\Models\Immo  $immo
     * @return void
     */
    public function forceDeleted(Immo $immo)
    {
        //
    }
}
