<?php

namespace App\Http\Controllers\Gerant;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CommandesController as ControllersCommandesController;
use App\Models\Commande;
use App\Models\Fournisseur;
use App\Models\Produit;
use App\Models\Station;
use Illuminate\Http\Request;

class CommandesController extends ControllersCommandesController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        //
        $commande = new Commande();
        $fournisseurs = Fournisseur::all();
        $produits = Produit::all();
        $stations = Station::all();

        $this->authorize('create', $commande);
        return view('commandes.create',compact('commande','fournisseurs','produits','stations'));
    }


}
