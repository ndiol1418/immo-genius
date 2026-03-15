<?php

namespace App\Utils;

use App\Models\Annonce;
use App\Models\Bien;
use App\Models\Commande;
use Illuminate\Support\Facades\Auth;
use App\Models\Compte;
use App\Models\Fournisseur;
use App\Models\Immo;
use App\Models\Produit;
use App\Models\Station;
use App\Models\User;
use Carbon\Carbon;

class DataStats
{

    public static function get(){
        $_user = Auth::user();
        $fournisseurs = Fournisseur::all();
        $biens = Bien::all();
        $annonces = [];
        $immos = Immo::all();

        if ($_user->role->profil->name == 'admin') {
            # code...
            $datas = [
                [
                    'title'=>'Agents',
                    'nbre'=>$fournisseurs->count(),
                    'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 5.5A3.5 3.5 0 0 1 15.5 9a3.5 3.5 0 0 1-3.5 3.5A3.5 3.5 0 0 1 8.5 9A3.5 3.5 0 0 1 12 5.5M5 8c.56 0 1.08.15 1.53.42c-.15 1.43.27 2.85 1.13 3.96C7.16 13.34 6.16 14 5 14a3 3 0 0 1-3-3a3 3 0 0 1 3-3m14 0a3 3 0 0 1 3 3a3 3 0 0 1-3 3c-1.16 0-2.16-.66-2.66-1.62a5.54 5.54 0 0 0 1.13-3.96c.45-.27.97-.42 1.53-.42M5.5 18.25c0-2.07 2.91-3.75 6.5-3.75s6.5 1.68 6.5 3.75V20h-13zM0 20v-1.5c0-1.39 1.89-2.56 4.45-2.9c-.59.68-.95 1.62-.95 2.65V20zm24 0h-3.5v-1.75c0-1.03-.36-1.97-.95-2.65c2.56.34 4.45 1.51 4.45 2.9z"/></svg>',
                    'col'=>'col-6 col-sm-6 col-lg-3',
                    'route'=>'admin.agents.index'
                ],
                [
                    'title'=>'Biens',
                    'nbre'=>$biens->count(),
                    'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" d="M19 14.77v-7l-5.5-3.847L8 7.769v2.692H7V7.29l6.5-4.635L20 7.289v7.48zm-4.904-6.328h.808v-.808h-.808zm-2 0h.808v-.808h-.808zm2 2h.808v-.808h-.808zm-2 0h.808v-.808h-.808zm-5.692 8.212l7.565 2.207l5.989-1.85q-.03-.455-.272-.656q-.244-.201-.551-.201H14.39q-.634 0-1.15-.05t-1.055-.238l-2.19-.718l.338-.988l2.025.732q.482.183 1.096.22q.613.036 1.68.042q0-.468-.172-.756t-.493-.402l-5.754-2.112q-.057-.019-.106-.028t-.105-.01h-2.1zm-4 2.346v-8.154H8.48q.14 0 .288.032t.275.074l5.779 2.117q.537.204.924.733q.388.529.388 1.352h3q.904 0 1.384.565q.481.566.481 1.435v.615l-6.98 2.154l-7.616-2.22V21zm1-1h2v-6.154h-2z"/></svg>',
                    'col'=>'col-6 col-sm-4 col-lg-3',
                    'route'=>'admin.biens.index',
                    'style'=>true
                ],
                [
                    'title'=>'immos',
                    'nbre'=>$immos->count(),
                    'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"><path d="M6 11.683c3.314-3.577 8.686-3.577 12 0M8 13.84c2.21-2.384 5.79-2.384 8 0M10 16c1.105-1.192 2.896-1.192 4 0"/><path d="M22 12.204v1.521c0 3.9 0 5.851-1.172 7.063S17.771 22 14 22h-4c-3.771 0-5.657 0-6.828-1.212S2 17.626 2 13.725v-1.521c0-2.289 0-3.433.52-4.381c.518-.949 1.467-1.537 3.364-2.715l2-1.241C9.889 2.622 10.892 2 12 2s2.11.622 4.116 1.867l2 1.241c1.897 1.178 2.846 1.766 3.365 2.715"/></g></svg>',
                    'col'=>'col-6 col-sm-4 col-lg-3',
                    'route'=>'admin.immos.index'
                ],
                [
                    'title'=>'Annonces',
                    'nbre'=>0,
                    'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 48 48"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M4.535 24.91v-2.65c0-.468.285-.888.72-1.06l3.651-1.391V8.806a1.32 1.32 0 0 1 2.62 0v.68c5.492 3.681 14.284 7.152 22.286 7.152h5.832a2 2 0 0 1 2 2v.89h0a1.91 1.91 0 0 1 1.89 1.921V25.7a1.9 1.9 0 0 1-1.95 1.84v.921a2 2 0 0 1-2 2h-2.2l-2.311 7.743a.89.89 0 0 1-.87.65H30.15q-.135.015-.27 0a1 1 0 0 1-.65-1.18l1.29-4.322h-.62a.8.8 0 0 1-.27 0a1 1 0 0 1-.64-1.18l.39-1.21a45.35 45.35 0 0 0-17.824 6.811v.62q.015.127 0 .25h0a1.311 1.311 0 1 1-2.611-.25V27.392L5.295 26a1.14 1.14 0 0 1-.76-1.09m4.371 2.451v-7.542"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M29.381 30.962c2.654-.332 5.308-.553 7.982-.5"/></svg>',
                    'col'=>'col-6 col-sm-4 col-lg-3',
                    'route'=>'admin.annonces.index'
                ]
                
            ];

        }else{
            $datas = [
            ];
        }
        return $datas;
    }
}
