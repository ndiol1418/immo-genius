<?php

namespace App\Http\Controllers;

use App\Models\DisponibiliteAgent;
use App\Models\Fournisseur;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RendezVousController extends Controller
{
    /**
     * Créer un rendez-vous depuis la fiche agent (modal RDV).
     * Accessible sans connexion : on stocke nom/tel/email dans notes.
     */
    public function store(Request $request)
    {
        $request->validate([
            'agent_id'   => ['required', 'exists:fournisseurs,id'],
            'nom_client' => ['required', 'string', 'max:120'],
            'tel_client' => ['required', 'string', 'max:30'],
            'email_client' => ['nullable', 'email', 'max:120'],
            'date'       => ['required', 'date', 'after_or_equal:today'],
            'heure'      => ['required', 'string'],
            'type_rdv'   => ['required', 'in:visite,consultation,autre'],
            'message'    => ['nullable', 'string', 'max:1000'],
        ]);

        $agent = Fournisseur::findOrFail($request->agent_id);

        $heureDebut = $request->heure . ':00';
        $heureFin   = date('H:i:s', strtotime($heureDebut) + 3600);

        $notes = json_encode([
            'nom'     => $request->nom_client,
            'tel'     => $request->tel_client,
            'email'   => $request->email_client,
            'message' => $request->message,
        ]);

        DisponibiliteAgent::create([
            'agent_id'    => $agent->id,
            'date'        => $request->date,
            'heure_debut' => $heureDebut,
            'heure_fin'   => $heureFin,
            'type_rdv'    => $request->type_rdv === 'autre' ? 'consultation' : $request->type_rdv,
            'statut'      => 'reserve',
            'client_id'   => auth()->id() ?? null,
            'notes'       => $notes,
        ]);

        // Notification email à l'agent
        if ($agent->user && $agent->user->email) {
            try {
                $subject = '📅 Nouveau rendez-vous – ' . $request->nom_client;
                $body    = "Bonjour {$agent->prenom},\n\n"
                         . "Vous avez une demande de rendez-vous :\n\n"
                         . "Client : {$request->nom_client}\n"
                         . "Téléphone : {$request->tel_client}\n"
                         . "Email : " . ($request->email_client ?? '—') . "\n"
                         . "Date : " . \Carbon\Carbon::parse($request->date)->format('d/m/Y') . "\n"
                         . "Heure : " . substr($heureDebut, 0, 5) . "\n"
                         . "Type : " . ucfirst($request->type_rdv) . "\n"
                         . "Message : " . ($request->message ?? '—') . "\n\n"
                         . "Connectez-vous sur " . config('app.url') . " pour confirmer.\n\n"
                         . config('app.name');

                Mail::raw($body, function ($m) use ($agent, $subject) {
                    $m->to($agent->user->email, $agent->nom_complet)
                      ->subject($subject)
                      ->from(config('mail.from.address', 'noreply@teranga-immo.sn'), config('app.name'));
                });
            } catch (\Exception $e) {
                // Silencieux si mail non configuré
            }
        }

        // Email de confirmation au client
        if ($request->email_client) {
            try {
                $subject = '✅ Confirmation de votre demande de RDV – ' . config('app.name');
                $body    = "Bonjour {$request->nom_client},\n\n"
                         . "Votre demande de rendez-vous avec {$agent->nom_complet} a bien été enregistrée.\n\n"
                         . "Date : " . \Carbon\Carbon::parse($request->date)->format('d/m/Y') . "\n"
                         . "Heure : " . substr($heureDebut, 0, 5) . "\n"
                         . "Type : " . ucfirst($request->type_rdv) . "\n\n"
                         . "L'agent vous contactera pour confirmer le rendez-vous.\n\n"
                         . config('app.name');

                Mail::raw($body, function ($m) use ($request, $subject) {
                    $m->to($request->email_client, $request->nom_client)
                      ->subject($subject)
                      ->from(config('mail.from.address', 'noreply@teranga-immo.sn'), config('app.name'));
                });
            } catch (\Exception $e) {
                // Silencieux si mail non configuré
            }
        }

        return back()->with('rdv_success', 'Votre demande de rendez-vous a été envoyée à ' . $agent->nom_complet . ' !');
    }

    /**
     * Envoyer un message direct à un agent (utilisateur connecté requis).
     */
    public function sendMessage(Request $request, $fournisseur_id)
    {
        $request->validate([
            'contenu' => ['required', 'string', 'max:2000'],
        ]);

        $agent   = Fournisseur::findOrFail($fournisseur_id);
        $agentUserId = $agent->user_id;

        if (!$agentUserId || $agentUserId === auth()->id()) {
            return back()->with('error', 'Impossible d\'envoyer un message à cet agent.');
        }

        // Conversation directe sans annonce
        $conversation = Conversation::firstOrCreate([
            'annonce_id'  => null,
            'acheteur_id' => auth()->id(),
            'agent_id'    => $agentUserId,
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => auth()->id(),
            'contenu'         => $request->contenu,
            'lu'              => false,
        ]);

        $conversation->touch();

        return redirect()->route('messages.show', $conversation->id)
                         ->with('success', 'Message envoyé à ' . $agent->nom_complet . ' !');
    }
}
