<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ProduitsImport;
use App\Models\Taxe;
use App\Models\Gamme;
use App\Models\Produit;
use App\Models\Fournisseur;
use App\Models\Famille;
use App\Models\SousFamille;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ProduitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.produits.index');
    }
    public function getData()
    {
        set_time_limit(3600);
        ini_set('memory_limit', '1024M');
        $data = Produit::with(['fournisseur'])->get();
        //->select(['id', 'designation','codebarre','colisage','prix_ttc'])->get(); // Sélectionner les colonnes nécessaires
        // dd($data[0]);
        return DataTables::of($data)
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('admin.produits.show',[$row->id]).'" data-id="'.$row->id.'" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>';
                    // $btn .= ' <a href="javascript:void(0)" data-id="'.$row->id.'" class="delete btn btn-danger btn-xs">Delete</a>';
                    return $btn;
                })
                ->addColumn('fournisseur', function($item) {
                    return isset($item->fournisseur)?$item->fournisseur->nom:'';
                })
                // ->addColumn('commandes', function($item) {
                //     return number_format($item->commande_lignes->count(),0,'',' ');
                // })
                ->addColumn('prix_ttc', function($item) {
                    return number_format($item->prix_ttc,0,'',' ');
                })
                ->rawColumns(['action','fournisseur'])
                ->make(true);
    }
    public function importProduits()
    {

        if (request()->hasFile('file')) {
            $csvFile = request('file');
            try {
                Excel::import(new ProduitsImport, $csvFile);
                //    dd($import);
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                $failures = $e->failures();
                $failures = $e->failures();
                dd($failures);

                foreach ($failures as $failure) {
                    $failure->row(); // row that went wrong
                    $failure->attribute(); // either heading key (if using heading row concern) or column index
                    $failure->errors(); // Actual error messages from Laravel validator
                    $failure->values(); // The values of the row that has failed.
                }
                dd($failures);
            }
        }
        // dd('ok');
        return back();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $taxes = Taxe::all();
        $gammes = Gamme::all();
        $produits = Produit::all();
        $familles = Famille::all();
        $fournisseurs = Fournisseur::all();
        $sous_familles = SousFamille::all();
        return view('admin.produits.create', compact('produits', 'fournisseurs', 'familles', 'sous_familles', 'gammes', 'taxes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'designation' => ['required'],
            'designation_courte' => ['nullable'],
            'codebarre' => ['nullable'],
            'code_barre_pcb' => ['nullable'],
            'fournisseur_id' => ['required'],
            'code' => ['required'],
            'famille_id' => ['nullable'],
            'sous_famille_id' => ['nullable'],
            'gamme_id' => ['nullable'],
            'prix_ht' => ['required'],
            'prix_unitaire_ht' => ['required'],
            'prix_ttc' => ['required'],
            'prix_vente_unit' => ['nullable'],
            'prix_vente_ht' => ['nullable'],
            'prix_vente_ttc' => ['nullable'],
            'tva_vente' => ['nullable']

        ]);
        $validatedData['compte_id'] = Auth::user()->compte_id;
        $validatedData['colisage'] = $request->input('colisage', 1);
        return Produit::create($validatedData) ?
            redirect()->route('admin.produits.index')->with('success', "Le produit a été ajouté avec succès") :
            redirect()->route('admin.produits.index')->with('error', "L'enregistrement du produit a échoué");
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
        $produit = Produit::find($id);
        return view('admin.produits.show',compact('produit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $taxes = Taxe::all();
        $gammes = Gamme::all();
        $produits = Produit::all();
        $familles = Famille::all();
        $fournisseurs = Fournisseur::all();
        $sous_familles = SousFamille::all();
        $produit = Produit::findOrFail($id);
        $selectedGammeId = $produit->gamme_id;
        return view('admin.produits.edit', compact('produit', 'fournisseurs', 'familles', 'sous_familles', 'gammes', 'taxes', 'selectedGammeId'));
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
        $validatedData = $request->validate([
            'designation' => ['required'],
            'designation_courte' => ['nullable'],
            'codebarre' => ['nullable'],
            'code_barre_pcb' => ['nullable'],
            'fournisseur_id' => ['required'],
            'code' => ['required'],
            'famille_id' => ['nullable'],
            'sous_famille_id' => ['nullable'],
            'gamme_id' => ['nullable'],
            'prix_ht' => ['required'],
            'prix_unitaire_ht' => ['required'],
            'prix_ttc' => ['required'],
            'prix_vente_unit' => ['nullable'],
            'prix_vente_ht' => ['nullable'],
            'prix_vente_ttc' => ['nullable'],
            'tva_vente' => ['nullable'],
        ]);
        $produit = Produit::find($id);
        $produit->update($validatedData);
        // dd($validatedData);
        $produit->colisage = $request->input('colisage', 1);
        $produit->save();

        return $produit ? redirect()->route('admin.produits.index')->with('success', "Le produit a été mis à jour avec succès")
            : redirect()->route('admin.produits.index')->with('error', "Le produit n'a pas été trouvé");
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
    public function toggleStatus($id)
    {
        $produit = Produit::findOrFail($id);
        $produit->statut = !$produit->statut;
        $produit->save();

        return redirect()->route('admin.produits.index')->with('success', 'Le statut du produit a été modifié avec succès.');
    }

}
