<?php

namespace App\Http\Controllers\Fournisseur;

use App\Http\Controllers\Admin\ImmosController as AdminImmosController;
use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Immo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ImmosController extends AdminImmosController
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->all();
        $request->validate([
            'immo.name'=>'required|max:255',
            'immo.montant'=>'required',
            'immo.type_immo_id'=>'required|exists:type_immos,id',
        ]);
        if (Auth::user()->fournisseur) {
            $data['immo']['fournisseur_id']= Auth::user()->fournisseur->id;
        }
        $data['immo']['type_location_id'] = request('type_location_id');
        if($immo = Immo::create($data['immo'])){
            $name = $data['immo']['name'];
            unset($data['immo']);
            $annonce = new Annonce();
            $annonce->pieces = $data['pieces'];
            $annonce->immo_id = $immo->id;
            $annonce->prix = $immo->montant;
            $annonce->name = $immo->name;
            $annonce->commune_id = $immo->bien?$immo->bien->commune_id:null;
            $annonce->departement_id = $immo->bien?$immo->commune()->departement_id:null;
            $annonce->slug = Str::slug($name.$immo->id);
            try {
                // dd($annonce);
                if($annonce->save()){
                    if(count($data['images']) > 0) $annonce->savePJ($data['images'],'App\Models\Annonce');
                }
                //code...
            } catch (\Throwable $th) {
                //throw $th;
                dd($th);
            }
        }
        Session::flash('success', __('general.success'));

        return redirect()->route('admin.immos.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
}
