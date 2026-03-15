<?php

namespace App\Http\Controllers\Fournisseur;

use App\Http\Controllers\Admin\BiensController as AdminBiensController;
use App\Models\Bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BiensController extends AdminBiensController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


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
        $bien = new Bien();
        $data = $request->validate([
            'name'=>'required|max:255',
            'superficie'=>'max:100',
            'montant'=>'required|max:11',
            'adresse'=>'max:200',
            'commune_id'=>'required|exists:communes,id',
            'type_id'=>'required|exists:types,id',
            'type_bien_id'=>'required|exists:type_biens,id',

        ]);
        $data['fournisseur_id'] = Auth::user()->fournisseur->id;
        if ($bien->create($data)) {
            Session::flash('success', __('general.success'));
            return redirect()->route('agent.biens.index');
        }
        Session::flash('error', __('general.error'));

        return back();
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
    public function update(Request $request, $id)
    {
        //
        $station = Bien::find($id);

        $request->validate([
            'name'=>'required|max:255',
        ]);
        $data = request()->all();
        $station->update($data) ?
            Session::flash('success', __('general.success'))  :
            Session::flash('error', __('general.error'));

        return redirect()->route('agent.biens.index');
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
