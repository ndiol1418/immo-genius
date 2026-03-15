<?php

namespace App\Console\Commands;

use App\Mail\AlerteMail;
use App\Models\Alerte;
use App\Models\Annonce;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class VerifierAlertes extends Command
{
    protected $signature   = 'alertes:verifier';
    protected $description = 'Vérifier les alertes actives et envoyer les emails de notification';

    public function handle()
    {
        $alertes = Alerte::where('actif', true)->with('user')->get();

        foreach ($alertes as $alerte) {
            $query = Annonce::where('status', 1)
                            ->where('created_at', '>=', now()->subDay());

            if ($alerte->type_transaction === 'louer') {
                $query->where('type_location_id', 2);
            } elseif ($alerte->type_transaction === 'acheter') {
                $query->where('type_location_id', 1);
            }

            if ($alerte->type_bien) {
                $query->whereHas('type_immo', fn($q) => $q->where('name', $alerte->type_bien));
            }

            if ($alerte->region) {
                $query->where('region', $alerte->region);
            }

            if ($alerte->commune) {
                $query->whereHas('commune', fn($q) => $q->where('name', $alerte->commune));
            }

            if ($alerte->prix_min) {
                $query->where('prix', '>=', $alerte->prix_min);
            }

            if ($alerte->prix_max) {
                $query->where('prix', '<=', $alerte->prix_max);
            }

            if ($alerte->chambres_min) {
                $query->where('chambres', '>=', $alerte->chambres_min);
            }

            $annonces = $query->with(['images', 'commune', 'type_immo'])->get();

            if ($annonces->count() > 0 && $alerte->user && $alerte->user->email) {
                Mail::to($alerte->user->email)->send(new AlerteMail($alerte, $annonces));
                $this->info("Email envoyé à {$alerte->user->email} ({$annonces->count()} annonce(s))");
            }
        }

        $this->info('Vérification des alertes terminée.');
    }
}
