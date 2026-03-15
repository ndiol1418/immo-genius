<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Compte;
use App\Models\Gamme;
use App\Models\GammeStation;
use App\Models\Station;
use App\Models\User;
use App\Models\Utils;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class StationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id=null)
    {
        //
        $stations = Station::actif()->get();

        if (isset($id)) {
            # code...
            $compte = Auth::user()->compte;
            $stations = $compte->stations;
        }
        $zones = Zone::all();
        $gammes = Gamme::all();
        return view('admin.stations.index',compact('stations','zones','gammes'));
    }
    public function getData()
    {
        $data = Station::all();
        return DataTables::of($data)
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('admin.produits.show',[$row->id]).'" data-id="'.$row->id.'" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>';
                    // $btn .= ' <a href="javascript:void(0)" data-id="'.$row->id.'" class="delete btn btn-danger btn-xs">Delete</a>';
                    return $btn;
                })
                ->addColumn('fournisseur', function($item) {
                    return $item->fournisseur->nom;
                })
                ->rawColumns(['action','fournisseur'])
                ->make(true);
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
        $station = new Station();
        $request->validate([
            'nom'=>'required|max:255',
            'email'=>'required|unique:users|max:200',
            'password' => 'required|confirmed'
        ]);
        $data = request()->all();
        $gammes = $data['gamme'];
        $data['user_id'] = Auth::user()->id;
        $data['compte_id'] = Auth::user()->compte_id;
        $user_data['Nom'] = request('Nom');
        $user_data['email'] = request('email');
        $user_data['password'] = request('password');
        $user_data['username'] = '---';
        $user_data['profil'] = 'gerant';
        $user_data['compte_id'] = Auth::user()->compte_id;
        // dd($data);
        $user = new User($user_data);
        if($user = User::storeOrUpdate($user_data)) {
            $data['user_id'] = $user->id;
            unset($data['Nom']);
            unset($data['gamme']);
            unset($data['user']);
            unset($data['password']);
            if ($station->create($data)) {
                foreach ($gammes as $key => $gamme) {
                    if(!in_array((int)$gamme,$station->gammes()->toArray())){
                        $new = new GammeStation();
                        $new->station_id = $station->id;
                        $new->gamme_id = (int) $gamme;
                        $new->save();
                    }
                }
                Session::flash('success', __('boutique.success_add_boutique'));
                return redirect()->route('admin.stations.index');
            }
            else{

                Session::flash('error', __('boutique.error_add_boutique'));
            }
        }
        Session::flash('error', __('boutique.error_add_boutique'));

        return back();
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
        $station = Station::find($id);
        $zones = Zone::all();
        $gammes = Gamme::all();
        $self   =     Utils::commandeGroupByYearMonth($station);
        $ca     =     Utils::getcaByYear($station);
        $commandes_en_cours   =     Utils::getcommandeEnCours($station);
        $ca_mois_en_cours     =     Utils::getCaMoisEnCours($station);
        $ca_mois_precedent    =     Utils::getCaMoisPrecedent($station);
        $commandes            =     Utils::commandeGroupByYearMonth($station);
        return view('admin.stations.show',compact('station','zones','gammes','ca_mois_en_cours','ca_mois_precedent','ca','commandes','commandes_en_cours'));
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
        $station = Station::find($id);
        $zones = Zone::all();
        $gammes = Gamme::all();
        return view('admin.stations.edit',compact('station','zones','gammes'));
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
        $station = Station::find($id);

        $request->validate([
            'nom'=>'required|max:255',
        ]);
        $data = request()->all();
        $gammes = $data['gamme'];
        unset($data['gamme']);
        if ($station->update($data)) {
            foreach ($gammes as $key => $gamme) {
                if(!in_array((int)$gamme,$station->gammes()->toArray())){
                    $new = new GammeStation();
                    $new->station_id = $station->id;
                    $new->gamme_id = (int) $gamme;
                    $new->save();
                }
            }
            DB::table('gamme_stations')->where('station_id',$station->id)->whereNotIn('gamme_id', $gammes)->delete();
        }
        $station->update($data) ?
            Session::flash('success', __('boutique.success_add_boutique'))  :
            Session::flash('error', __('boutique.error_add_boutique'));

        return back();
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
        $station = Station::find($id);
        $station->status= 0;
        if($station->update()) {
            Session::flash('success',__('gamme.success_delete'));
        } else {
            Session::flash('error', __('gamme.error_delete'));
        }

        return back();
    }
}
