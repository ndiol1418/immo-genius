<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class ProfilAgentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        $agent = Fournisseur::where('user_id', auth()->id())->firstOrFail();
        return view('agent-match.profil-edit', compact('agent'));
    }

    public function update(Request $request)
    {
        $agent = Fournisseur::where('user_id', auth()->id())->firstOrFail();

        $request->validate([
            'description_pro'  => ['nullable', 'string', 'max:2000'],
            'experience_annees'=> ['nullable', 'integer', 'min:0', 'max:50'],
            'disponibilite'    => ['nullable', 'in:disponible,occupe,conge'],
            'facebook'         => ['nullable', 'url'],
            'linkedin'         => ['nullable', 'url'],
            'instagram'        => ['nullable', 'url'],
        ]);

        $agent->update([
            'description_pro'   => $request->description_pro,
            'experience_annees' => $request->experience_annees ?? 0,
            'disponibilite'     => $request->disponibilite ?? 'disponible',
            'specialites'       => $request->specialites ? array_filter($request->specialites) : [],
            'certifications'    => $request->certifications ? array_filter(explode(',', $request->certifications)) : [],
            'reseaux_sociaux'   => array_filter([
                'facebook'  => $request->facebook,
                'linkedin'  => $request->linkedin,
                'instagram' => $request->instagram,
            ]),
        ]);

        return back()->with('success', 'Profil mis à jour avec succès !');
    }
}
