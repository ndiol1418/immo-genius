<?php

namespace App\Http\Controllers;

use App\Library\Pays;
use App\Models\AnnonceFront;
use App\Models\Commande;
use App\Models\Compte;
use App\Models\Desserte;
use App\Models\Devise;
use App\Models\Famille;
use App\Models\Fournisseur;
use App\Models\Gamme;
use App\Models\Produit;
use App\Models\Promotion;
use App\Models\Reception;
use App\Models\Station;
use App\Models\Taxe;
use App\Models\User;
use App\Models\Utils;
use App\Models\Zone;
use App\Utils\DataStats;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends DashboardController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {        
        $annonces = AnnonceFront::with(['immo.bien'])->whereNull('type_immo_id')->where('type_location_id',2)->get();
        foreach ($annonces as $key => $value) {
            $value->update(['type_immo_id'=>$value->immo->type_immo_id]);
        }
        return view('home');
    }

    public function getCards(){
        $datas = DataStats::get();
        return view('admin.comptes.card',compact('datas'));
    }

}
