<?php

namespace App\Scopes;

use App\Models\Fournisseur;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class FournisseurScope implements Scope{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model){
        $user = Auth::user();

        if(Auth::check() && $user->role->profil->name == 'fournisseur') {
            // $fournisseur = $builder->where('user_id',$user->id)->get();
            // $builder->where('user_id', $user->id);
            // $fournisseur = $user->fournisseurs[0];
            // $builder->where('owner_id', $fournisseur->id);
        }
    }
}
