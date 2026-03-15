<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = Auth::id();

        $conversations = Conversation::where('acheteur_id', $userId)
            ->orWhere('agent_id', $userId)
            ->with(['annonce', 'acheteur', 'agent', 'dernierMessage'])
            ->latest('updated_at')
            ->get();

        return view('messages.index', compact('conversations', 'userId'));
    }

    public function show(Conversation $conversation)
    {
        $userId = Auth::id();

        // Vérifier que l'utilisateur fait partie de la conversation
        if ($conversation->acheteur_id !== $userId && $conversation->agent_id !== $userId) {
            abort(403);
        }

        // Marquer comme lus les messages reçus
        $conversation->messages()
            ->where('sender_id', '!=', $userId)
            ->where('lu', false)
            ->update(['lu' => true]);

        $messages = $conversation->messages()->with('sender')->oldest()->get();

        return view('messages.show', compact('conversation', 'messages', 'userId'));
    }

    public function store(Request $request, Conversation $conversation)
    {
        $userId = Auth::id();

        if ($conversation->acheteur_id !== $userId && $conversation->agent_id !== $userId) {
            abort(403);
        }

        $request->validate(['contenu' => 'required|string|max:2000']);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => $userId,
            'contenu'         => $request->contenu,
            'lu'              => false,
        ]);

        $conversation->touch();

        return redirect()->route('messages.show', $conversation->id);
    }

    public function contact(Request $request, $annonce_id)
    {
        $annonce = Annonce::withoutGlobalScope(\App\Scopes\AnnonceScope::class)->findOrFail($annonce_id);

        $acheteur_id = Auth::id();
        $agent_id    = $annonce->immo && $annonce->immo->fournisseur
                       ? $annonce->immo->fournisseur->user_id
                       : null;

        if (!$agent_id || $agent_id === $acheteur_id) {
            return redirect()->back()->with('error', 'Impossible de contacter cet agent.');
        }

        // Trouver ou créer la conversation
        $conversation = Conversation::firstOrCreate(
            ['annonce_id' => $annonce->id, 'acheteur_id' => $acheteur_id, 'agent_id' => $agent_id]
        );

        $request->validate(['contenu' => 'required|string|max:2000']);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => $acheteur_id,
            'contenu'         => $request->contenu,
            'lu'              => false,
        ]);

        $conversation->touch();

        return redirect()->route('messages.show', $conversation->id)
                         ->with('success', 'Message envoyé !');
    }
}
