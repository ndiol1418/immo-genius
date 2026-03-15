<?php
namespace App\Console\Commands;

use App\Mail\EcheanceLoyerMail;
use App\Mail\LoyerRetardMail;
use App\Models\ContratLocation;
use App\Models\PaiementLoyer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class LoyerNotifications extends Command
{
    protected $signature = 'loyer:notifications';
    protected $description = 'Envoie rappels échéance et alertes retard loyer';

    public function handle()
    {
        $mois = now()->format('Y-m');

        // 1. Rappel 5 jours avant échéance (premier du mois suivant)
        $echeance = now()->addDays(5)->startOfMonth();
        if (now()->addDays(5)->day === 1) {
            $contrats = ContratLocation::where('statut', 'actif')->with('locataire')->get();
            foreach ($contrats as $c) {
                try { Mail::to($c->locataire->email)->send(new EcheanceLoyerMail($c)); } catch (\Throwable $e) {}
            }
        }

        // 2. Alerte retard : contrats actifs dont le paiement du mois est absent ou en retard
        $contrats = ContratLocation::where('statut', 'actif')->with('agent')->get();
        foreach ($contrats as $c) {
            $p = PaiementLoyer::where('contrat_id', $c->id)->where('mois_concerne', $mois)->first();
            if (!$p || $p->statut === 'retard') {
                if ($p && $p->statut !== 'retard') {
                    $p->update(['statut' => 'retard']);
                }
                try { Mail::to($c->agent->email)->send(new LoyerRetardMail($c)); } catch (\Throwable $e) {}
            }
        }

        $this->info('Notifications loyer envoyées.');
    }
}
