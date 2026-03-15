<?php

namespace App\Http\Controllers\Fournisseur;

use App\Http\Controllers\Admin\FournisseursController as AdminFournisseursController;
use App\Http\Controllers\Controller;
use App\Models\Fournisseur;
use App\Models\Immo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FournisseursController extends AdminFournisseursController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = Auth::user();
        $fournisseurs = Fournisseur::where('ouwner_id',$user->fournisseur->id)->actif()->get();
        return view('admin.fournisseurs.index', compact('fournisseurs'));
    }
    public function link(Request $request,$id){
        $immo = Immo::find($id);
        $agents  = array_merge ($immo->fournisseur->agents->toArray(),request('agents'));
        // dd($agents);
        $immo->fournisseur->update(['agents'=>$agents])?
        Session::flash('success', "L'opération a été effectuée."):
        Session::flash('error', "L'opération a échoué.");
        return redirect()->back();
    }
    public function unlink(Request $request,$id){
        $fournisseur = Fournisseur::find($id);
        $agent  = Auth::user()->fournisseur;
        $array = $fournisseur->agents->toArray();
        $search = array_filter($array,function($v) use($agent){
            return $v!=$agent->id;
        });
        // dd($search);
        $fournisseur->update(['agents'=>$search])?
        Session::flash('success', "L'opération a été effectuée."):
        Session::flash('error', "L'opération a échoué.");
        return redirect()->back();
    }
    public function reseaux(){
        $fournisseur = Auth::user()->fournisseur;
        $immos = $fournisseur->mes_immos;
        return view('fournisseur.reseaux.index',compact('immos'));
    }
}
