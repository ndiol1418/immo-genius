<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CommandesExport;
use App\Http\Controllers\Controller;
use App\Models\Reception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;

class ReceptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $receptions = Reception::all();
        return view('receptions.index',compact('receptions'));
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
    public function pdf($id)
    {
        //
        $reception = Reception::find($id);
        $pdf = App::make('dompdf.wrapper');
        $titre = $reception->is_retour==1?'Retour':'Reception';
        $detail = $reception->is_retour==1?'Retour':'';
        $pdf->loadView('pdf.bonReceptionPdf', compact("reception",'detail','titre'));
        return $pdf->stream();
    }
    public function preview($id)
    {
        //
        $reception = Reception::find($id);

        return Excel::download(new CommandesExport($reception->reception_lignes),'RPA-'.$id.'.xlsx');
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
