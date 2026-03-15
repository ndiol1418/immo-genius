<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Favori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavorisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function toggle($annonce_id)
    {
        $favori = Favori::where('user_id', Auth::id())
                        ->where('annonce_id', $annonce_id)
                        ->first();

        if ($favori) {
            $favori->delete();
            return response()->json(['status' => 'removed', 'message' => 'Retiré des favoris']);
        }

        Favori::create([
            'user_id'    => Auth::id(),
            'annonce_id' => $annonce_id,
        ]);

        return response()->json(['status' => 'added', 'message' => 'Ajouté aux favoris']);
    }

    public function index()
    {
        $favoris = Favori::where('user_id', Auth::id())
                         ->with(['annonce.images', 'annonce.commune', 'annonce.type_immo'])
                         ->latest()
                         ->get();

        return view('favoris.index', compact('favoris'));
    }
}
