<?php

namespace App\Http\Controllers\Gerant;

use App\Http\Controllers\Controller;
use App\Models\Gamme;
use App\Models\Station;
use App\Models\Utils;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->station->id;
        $station = Station::find($id);
        $zones =    Zone::all();
        $gammes =     Gamme::all();
        $self   =     Utils::commandeGroupByYearMonth($station);
        $ca     =     Utils::getcaByYear($station);
        $commandes_en_cours   =     Utils::getcommandeEnCours($station);
        $ca_mois_en_cours     =     Utils::getCaMoisEnCours($station);
        $ca_mois_precedent    =     Utils::getCaMoisPrecedent($station);
        $commandes            =     Utils::commandeGroupByYearMonth($station);
        return view('admin.stations.show',compact('station','zones','gammes','ca_mois_en_cours','ca_mois_precedent','ca','commandes','commandes_en_cours'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
