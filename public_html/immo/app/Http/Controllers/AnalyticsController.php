<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\AnnonceVue;
use App\Models\Conversation;
use App\Models\Fournisseur;
use App\Scopes\AnnonceScope;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $agent = Fournisseur::where('user_id', $user->id)->first();

        if (!$agent) {
            abort(403, "Vous n'êtes pas un agent.");
        }

        // Annonces de cet agent (via immos)
        $annonceIds = Annonce::withoutGlobalScope(AnnonceScope::class)
            ->whereHas('immo', fn($q) => $q->where('fournisseur_id', $agent->id))
            ->pluck('id');

        // Vues totales par annonce
        $vuesParAnnonce = AnnonceVue::whereIn('annonce_id', $annonceIds)
            ->select('annonce_id', DB::raw('COUNT(*) as total'))
            ->groupBy('annonce_id')
            ->orderByDesc('total')
            ->with('annonce')
            ->get();

        // Top 5 annonces les plus vues
        $top5 = $vuesParAnnonce->take(5);

        // Contacts reçus par annonce (conversations)
        $contactsParAnnonce = Conversation::whereIn('annonce_id', $annonceIds)
            ->select('annonce_id', DB::raw('COUNT(*) as total'))
            ->groupBy('annonce_id')
            ->pluck('total', 'annonce_id');

        // Évolution vues sur 30 jours
        $vues30j = AnnonceVue::whereIn('annonce_id', $annonceIds)
            ->where('created_at', '>=', now()->subDays(29))
            ->select(DB::raw('DATE(created_at) as jour'), DB::raw('COUNT(*) as total'))
            ->groupBy('jour')
            ->orderBy('jour')
            ->pluck('total', 'jour');

        // Remplir les jours manquants avec 0
        $labels30j = [];
        $data30j   = [];
        for ($i = 29; $i >= 0; $i--) {
            $jour = now()->subDays($i)->format('Y-m-d');
            $labels30j[] = now()->subDays($i)->format('d/m');
            $data30j[]   = $vues30j[$jour] ?? 0;
        }

        // Stats globales
        $totalVues     = AnnonceVue::whereIn('annonce_id', $annonceIds)->count();
        $totalContacts = Conversation::whereIn('annonce_id', $annonceIds)->count();
        $tauxConv      = $totalVues > 0 ? round($totalContacts / $totalVues * 100, 1) : 0;

        // Données pour le graphique barres (top 10)
        $barLabels = $vuesParAnnonce->take(10)->map(fn($v) =>
            \Str::limit($v->annonce?->name ?? '#'.$v->annonce_id, 20)
        );
        $barData = $vuesParAnnonce->take(10)->pluck('total');

        return view('analytics.index', compact(
            'agent', 'top5', 'vuesParAnnonce', 'contactsParAnnonce',
            'totalVues', 'totalContacts', 'tauxConv',
            'labels30j', 'data30j', 'barLabels', 'barData'
        ));
    }
}
