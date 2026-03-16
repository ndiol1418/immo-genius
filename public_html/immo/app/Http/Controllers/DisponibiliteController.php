<?php

namespace App\Http\Controllers;

use App\Models\DisponibiliteAgent;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class DisponibiliteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /** Réserver un créneau (côté client) */
    public function reserver(Request $request, DisponibiliteAgent $creneau)
    {
        if ($creneau->statut !== 'disponible') {
            return back()->with('error', 'Ce créneau n\'est plus disponible.');
        }

        $creneau->update([
            'statut'    => 'reserve',
            'client_id' => auth()->id(),
            'notes'     => $request->notes,
        ]);

        return back()->with('success', 'Créneau réservé ! L\'agent vous contactera pour confirmer.');
    }

    /** Ajouter un créneau (côté agent) */
    public function store(Request $request)
    {
        $request->validate([
            'date'        => ['required', 'date', 'after_or_equal:today'],
            'heure_debut' => ['required'],
            'heure_fin'   => ['required'],
            'type_rdv'    => ['required', 'in:visite,consultation,signature'],
        ]);

        $agent = Fournisseur::where('user_id', auth()->id())->firstOrFail();

        DisponibiliteAgent::create([
            'agent_id'    => $agent->id,
            'date'        => $request->date,
            'heure_debut' => $request->heure_debut,
            'heure_fin'   => $request->heure_fin,
            'type_rdv'    => $request->type_rdv,
            'statut'      => 'disponible',
        ]);

        return back()->with('success', 'Créneau ajouté.');
    }

    /** Supprimer un créneau (côté agent) */
    public function destroy(DisponibiliteAgent $creneau)
    {
        $agent = Fournisseur::where('user_id', auth()->id())->firstOrFail();
        if ($creneau->agent_id !== $agent->id) abort(403);
        $creneau->delete();
        return back()->with('success', 'Créneau supprimé.');
    }
}
