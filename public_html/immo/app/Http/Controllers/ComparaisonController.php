<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;

class ComparaisonController extends Controller
{
    public function index(Request $request)
    {
        $ids = array_filter(explode(',', $request->get('ids', '')));
        $annonces = collect();

        if (count($ids)) {
            $annonces = Annonce::withoutGlobalScopes()
                ->with(['immo', 'images', 'commune.departement', 'typeLocation', 'pieces'])
                ->whereIn('id', array_slice($ids, 0, 3))
                ->get();
        }

        return view('comparaison.index', compact('annonces'));
    }
}
