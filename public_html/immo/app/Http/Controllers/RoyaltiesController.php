<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Fournisseur;
use App\Models\Station;
use App\Models\Utils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RoyaltiesController extends Controller
{
    //
    public function fournisseur(){
        $months = array_map(fn($month) => Carbon::create(null, $month)->format('F'), range(1, 12));
        $debut = Carbon::now();
        $fin = Carbon::now();
        $fin = Carbon::now();
        $month = $debut->format('F Y');
        $fournisseurs = Fournisseur::all();
        $res = Utils::CaMoisEnCoursFournisseurs();
        $ca = Utils::CaMoisEnCoursFournisseurs()['ca'];
        $ca_royalties = Utils::getCaMoisEnCoursRoyaltiesFournisseurs();
        $ca = self::dataRequest($res)?self::dataRequest($res): $ca;
        if(request()->has('debut') && request()->has('fin')) {
            $debut = Carbon::createFromFormat('Y-m', request('debut'));
            $fin = Carbon::createFromFormat('Y-m', request('fin'));
        }
        return view('admin.royalties.fournisseurs',compact('fournisseurs','months','month','ca_royalties','ca','debut','fin'));
    }
    public function getDataFournisseurs()
    {
        $debut = Carbon::createFromDate(request('start_date'));
        $res = Utils::CaMoisEnCoursFournisseurs();
        $ca = Utils::CaMoisEnCoursFournisseurs()['ca'];
        $ca = self::dataRequest($res)?self::dataRequest($res): $ca;
        $data = Fournisseur::all();
        return DataTables::of($data)

                ->addColumn('royalties', function($item) {
                    return $item->royalties()['commandes'];
                })
                ->addColumn('ca', function($item) {
                    return $item->getCaCurrentMonth();
                })
                ->addColumn('ca_royalties', function($item) {
                    return $item->ca_royalties();
                })
                ->rawColumns(['royalties','ca','ca_royalties'])
                ->make(true);
    }
    public function station(){
        set_time_limit(3600);
        $months = array_map(fn($month) => Carbon::create(null, $month)->format('F'), range(1, 12));
        $debut = Carbon::now();
        $fin = Carbon::now();
        $fin = Carbon::now();
        $month = $debut->format('F Y');
        $ca_royalties = Utils::getCaMoisEnCoursRoyaltiesStations();
        $ca = Utils::CaMoisEnCoursStations()['ca'];
        // dd($ca);
        $stations = Station::all();

        if(request()->has('debut') && request()->has('fin')) {
            $debut = Carbon::createFromFormat('Y-m', request('debut'));
            $fin = Carbon::createFromFormat('Y-m', request('fin'));
        }
        return view('admin.royalties.stations',compact('months','month','debut','fin','stations','ca_royalties','ca'));
    }
    public function listeRoyaltieStations(){
        $stations = Station::all();
        return view('admin.royalties.partials.liste-stations',compact('stations'));

    }
    public function getCardCa($debut,$fin){
        $debut = Carbon::createFromDate($debut);
        $fin = Carbon::createFromDate($fin);
        $ca_royalties = Utils::getCaMoisEnCoursRoyaltiesStations();
        $ca = Utils::CaMoisEnCoursStations()['ca'];
        return view('admin.royalties.partials.card-ca',compact('ca','ca_royalties'));

    }
    public function dataRequest($res){
        if(request()->has('debut') && request()->has('fin')) {
            $debut = Carbon::createFromFormat('Y-m', request('debut'));
            $fin = Carbon::createFromFormat('Y-m', request('fin'));
            $array_1 = $res['data'];
            return $array_1->get()->filter(function($item) use ($debut, $fin) {
                $debut = $debut->firstOfMonth();
                $fin = $fin->lastOfMonth();
                return Carbon::parse($item->commande_date)->isBetween($debut->format('Y-m-d'),$fin->format('Y-m-d'));

            })->sum('montant_ht');
        }
        return false;
    }

    public function periodique($param=null){
        $debut = Carbon::now();
        $fin = Carbon::now();
        $fin = Carbon::now();
        $date = now();

        $commande_by_year = Commande::ConfirmeOrTraites()
                        ->where(DB::raw("DATE_FORMAT(commande_date,'%Y')"),$param?$param:$date->format('Y'))
                        ->orderBy('commande_date','DESC')->get();
        $commandes = Commande::traite()
                        // ->where(DB::raw("DATE_FORMAT(commande_date,'%Y-%m')"),$date)
                        ->orderBy('commande_date','DESC')->get();
        $groupsByYears = $commandes->groupBy(function($date){
            return Carbon::createFromDate($date->commande_date)->format('Y');//->locale('fr')->isoFormat('YYYY');
        });
        $groupsByYear = $commande_by_year->groupBy(function($date){
            return Carbon::createFromDate($date->commande_date)->format('Y');//->locale('fr')->isoFormat('YYYY');
        });
        // foreach($groupsByYears as $key => $group){
        //     $month = $group->groupBy(function($date){
        //         return Carbon::createFromDate($date->commande_date)->locale('fr')->isoFormat('MMMM');
        //     });
        //     $groupsByYears[$key] = $month;
        // }
        foreach($groupsByYear as $key => $group){
            $month = $group->groupBy(function($date){
                return Carbon::createFromDate($date->commande_date)->locale('fr')->isoFormat('MMMM');
            });
            $groupsByYear[$key] = $month;
        }
        if(!$param) $param=$date->format('Y');
        return view('admin.royalties.periodiques',compact('debut','fin','groupsByYears','groupsByYear','param'));
    }
}
