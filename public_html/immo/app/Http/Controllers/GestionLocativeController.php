<?php
namespace App\Http\Controllers;

use App\Mail\EcheanceLoyerMail;
use App\Mail\LoyerRetardMail;
use App\Mail\ContratSigneMail;
use App\Models\Annonce;
use App\Models\ContratLocation;
use App\Models\Fournisseur;
use App\Models\PaiementLoyer;
use App\Models\User;
use App\Scopes\AnnonceScope;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class GestionLocativeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $agent = Fournisseur::where('user_id', $user->id)->first();
        if (!$agent) abort(403, "Accès réservé aux agents.");

        $contrats = ContratLocation::where('agent_id', $user->id)
            ->with(['annonce', 'locataire', 'paiements'])
            ->orderByDesc('created_at')
            ->get();

        return view('gestion-locative.index', compact('contrats'));
    }

    public function create()
    {
        $annonces = Annonce::withoutGlobalScope(AnnonceScope::class)
            ->whereHas('immo', function($q) {
                $q->where('fournisseur_id', auth()->user()->fournisseur?->id);
            })->get();
        $locataires = User::all();
        return view('gestion-locative.create', compact('annonces', 'locataires'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'annonce_id'     => 'required|exists:annonces,id',
            'locataire_id'   => 'required|exists:users,id',
            'date_debut'     => 'required|date',
            'loyer_mensuel'  => 'required|numeric|min:0',
        ]);

        ContratLocation::create([
            'annonce_id'    => $request->annonce_id,
            'locataire_id'  => $request->locataire_id,
            'agent_id'      => auth()->id(),
            'date_debut'    => $request->date_debut,
            'date_fin'      => $request->date_fin,
            'loyer_mensuel' => $request->loyer_mensuel,
            'charges'       => $request->charges ?? 0,
            'caution'       => $request->caution ?? 0,
            'statut'        => 'actif',
        ]);

        return redirect()->route('gestion-locative.index')
            ->with('success', 'Contrat créé avec succès.');
    }

    public function show(ContratLocation $contrat)
    {
        $this->authorize_agent($contrat);
        $contrat->load(['annonce.images', 'locataire', 'paiements']);
        return view('gestion-locative.show', compact('contrat'));
    }

    public function enregistrerPaiement(Request $request, ContratLocation $contrat)
    {
        $this->authorize_agent($contrat);
        $request->validate([
            'mois_concerne' => 'required',
            'montant'       => 'required|numeric|min:0',
        ]);

        PaiementLoyer::updateOrCreate(
            ['contrat_id' => $contrat->id, 'mois_concerne' => $request->mois_concerne],
            [
                'montant'       => $request->montant,
                'date_paiement' => now(),
                'statut'        => 'paye',
            ]
        );

        return back()->with('success', 'Paiement enregistré.');
    }

    public function quittancePdf(ContratLocation $contrat, string $mois)
    {
        $this->authorize_agent($contrat);
        $paiement = $contrat->paiements()->where('mois_concerne', $mois)->firstOrFail();
        $pdf = Pdf::loadView('gestion-locative.quittance-pdf', compact('contrat', 'paiement', 'mois'));
        return $pdf->download("quittance-{$mois}.pdf");
    }

    public function signer(Request $request, ContratLocation $contrat)
    {
        $user = auth()->user();
        $request->validate(['signature' => 'required|string']);

        if ($user->id === $contrat->agent_id) {
            $contrat->signature_agent = $request->signature;
            $contrat->date_signature_agent = now();
        } elseif ($user->id === $contrat->locataire_id) {
            $contrat->signature_locataire = $request->signature;
            $contrat->date_signature_locataire = now();
        } else {
            abort(403);
        }

        if ($contrat->signature_agent && $contrat->signature_locataire) {
            $contrat->contrat_signe = true;
            // Générer PDF et envoyer aux deux parties
            $pdf = Pdf::loadView('gestion-locative.contrat-pdf', compact('contrat'));
            $pdfPath = storage_path("app/contrats/contrat-{$contrat->id}.pdf");
            if (!is_dir(dirname($pdfPath))) mkdir(dirname($pdfPath), 0755, true);
            $pdf->save($pdfPath);

            try {
                Mail::to($contrat->agent->email)->send(new ContratSigneMail($contrat, $pdfPath));
                Mail::to($contrat->locataire->email)->send(new ContratSigneMail($contrat, $pdfPath));
            } catch (\Throwable $e) {}
        }

        $contrat->save();
        return back()->with('success', 'Signature enregistrée.');
    }

    public function contratPdf(ContratLocation $contrat)
    {
        $this->authorize_agent_or_locataire($contrat);
        $pdf = Pdf::loadView('gestion-locative.contrat-pdf', compact('contrat'));
        return $pdf->download("contrat-{$contrat->id}.pdf");
    }

    private function authorize_agent(ContratLocation $contrat)
    {
        if (auth()->id() !== $contrat->agent_id) abort(403);
    }

    private function authorize_agent_or_locataire(ContratLocation $contrat)
    {
        if (auth()->id() !== $contrat->agent_id && auth()->id() !== $contrat->locataire_id) abort(403);
    }
}
