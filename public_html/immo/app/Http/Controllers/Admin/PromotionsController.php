<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\UtilitiesController;
use App\Http\Controllers\Controller;
use App\Models\Fournisseur;
use App\Models\Promotion;
use App\Models\Produit;
use App\Models\EnPromo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PromotionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $titre = "Promotions";
        return view('admin.promotions.index', compact('titre'));
    }

    public function enCours(){
        $titre="Promotions en cours";
        $promotions=Promotion::where('active', 1)->EnCours()->get();
        return view('admin.promotions.index', compact('promotions','titre'));
    }

    public function terminees(){
        $titre="Promotions terminées";
        $promotions=Promotion::where('active',1)->Terminees()->get();
        return view('admin.promotions.index', compact('promotions','titre'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fournisseurs = Fournisseur::all();
        $produits = Produit::all();
        $en_promos = [];
        return view('admin.promotions.create', compact('produits', 'fournisseurs','en_promos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data_promotion = request("promo");
        $data_en_promos = request("en_promo");

        // Vérifier si $data_en_promos est vide
        if(empty($data_en_promos)) {
            return redirect()->back()->with('error', 'Veuillez remplir les détails de la promotion.');
        }

        $data_promotion['compte_id'] = Auth::user()->compte_id;
        $data_promotion['active'] = 1;
        $promotion = Promotion::createOrUpdate(null, $data_promotion);

        foreach ($data_en_promos as $en_promo) {
            $en_promo["promotion_id"] = $promotion->id;
            EnPromo::create($en_promo);
        }

        return $promotion ? redirect()->route('admin.promotions.en_cours')->with('success', "La promotion a été créée avec succès")
            : redirect()->route('admin.promotions.en_cours')->with('error', "La promotion n'a pas été créée");
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $promotion = Promotion::find($id);
        return view('admin.promotions.show', compact('promotion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $promotion = Promotion::findOrFail($id);
        $fournisseurs = Fournisseur::actif()->get();
        $produits = Produit::actif()->get();

        // Récupérer les produits associés à la promotion spécifique via la relation enPromos
        $en_promos = isset($promotion->en_promos) ? $promotion->en_promos: [];

        return view('admin.promotions.edit', compact('promotion', 'produits', 'fournisseurs', 'en_promos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
       // dd($request->all());
        $data_promotion=request("promo");
        $data_en_promos=request("en_promo");
        $promotion=Promotion::createOrUpdate($id,$data_promotion);
        if($promotion){
            if(isset($data_en_promos) && count($data_en_promos)>0) {
                foreach($data_en_promos as $en_promo){
                    $en_promo["promotion_id"]=$promotion->id;
                    EnPromo::create($en_promo);
                }
            }
            Session::flash('success', 'Le produit enregistré avec succès!') ;
        }else Session::flash('error', 'Le roduit n\'a pas ete enregistré !') ;

        return back();
    }

    public function supprimerProduitEnPromo (){
        $id= request("id");
        $en_promo = EnPromo::supprimerLigne($id);
        if($en_promo) $rep = ['info'=>"Le produit a été supprimé."];
        else $rep = ['info'=>"Le produit n'a pas été supprimé."];
        return response()->json($rep);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $promotion = Promotion::find($id);

        if ($promotion) {
            $promotion->update(['active' => 0]);
            return redirect()->route('admin.promotions.en_cours')->with('success', "La promotion a été désactivée avec succès");
        } else {
            return redirect()->route('admin.promotions.en_cours')->with('error', "La promotion n'a pas été trouvée");
        }
    }

}
