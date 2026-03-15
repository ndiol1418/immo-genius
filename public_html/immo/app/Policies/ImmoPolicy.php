<?php

namespace App\Policies;

use App\Models\Immo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ImmoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Immo  $immo
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Immo $immo)
    {
        //
        // dd($immo);
    }
    public function modif(User $user, Immo $immo)
    {
        //
        $isAuthorise = false;
        if(in_array($user->role->profil_id ,[1,2])){
            $agent = $immo->fournisseur;
            if (in_array($user->role->profil_id ,[2])) {
                if($agent->is_agent!=0 || $agent->id == $user->fournisseur->id || $user->role->profil_id == 1){
                    $isAuthorise = true;
                }
            }
            if($user->role->profil_id == 1){
                $isAuthorise = true;
            }
        }
        return $isAuthorise
        ? Response::allow('authorisé')
        : Response::deny("Vous n'êtes pas autorisé à la prise en main de la réclamation");
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Immo  $immo
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Immo $immo)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Immo  $immo
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Immo $immo)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Immo  $immo
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Immo $immo)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Immo  $immo
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Immo $immo)
    {
        //
    }
}
