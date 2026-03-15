<?php

namespace App\Http\Controllers;

use App\Models\Alerte;
use App\Models\TypeImmo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlertesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $alertes    = Alerte::where('user_id', Auth::id())->latest()->get();
        $type_immos = TypeImmo::all();

        return view('alertes.index', compact('alertes', 'type_immos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_transaction' => 'nullable|in:louer,acheter',
            'prix_min'         => 'nullable|integer|min:0',
            'prix_max'         => 'nullable|integer|min:0',
            'chambres_min'     => 'nullable|integer|min:0',
        ]);

        Alerte::create([
            'user_id'          => Auth::id(),
            'type_bien'        => $request->type_bien,
            'type_transaction' => $request->type_transaction,
            'region'           => $request->region,
            'departement'      => $request->departement,
            'commune'          => $request->commune,
            'prix_min'         => $request->prix_min,
            'prix_max'         => $request->prix_max,
            'chambres_min'     => $request->chambres_min,
            'actif'            => true,
        ]);

        return redirect()->route('alertes.index')->with('success', 'Alerte créée avec succès !');
    }

    public function destroy(Alerte $alerte)
    {
        if ($alerte->user_id !== Auth::id()) abort(403);
        $alerte->delete();
        return redirect()->route('alertes.index')->with('success', 'Alerte supprimée.');
    }

    public function toggle(Alerte $alerte)
    {
        if ($alerte->user_id !== Auth::id()) abort(403);
        $alerte->update(['actif' => !$alerte->actif]);
        return redirect()->route('alertes.index');
    }
}
