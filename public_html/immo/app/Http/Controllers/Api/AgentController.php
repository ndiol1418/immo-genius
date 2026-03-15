<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AgentListResource;
use App\Http\Resources\AgentResource;
use App\Models\Fournisseur;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AgentController extends Controller
{
    /**
     * Liste paginée des agents actifs.
     *
     * GET /api/v1/agents
     *
     * Filtres optionnels (query params) :
     *   - commune_id       : int
     *   - specialisation_id: int
     *   - is_premium       : true|false
     *   - per_page         : taille de page (défaut: 15, max: 50)
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $request->validate([
            'commune_id'        => ['nullable', 'integer'],
            'specialisation_id' => ['nullable', 'integer'],
            'is_premium'        => ['nullable', 'boolean'],
            'per_page'          => ['nullable', 'integer', 'min:1', 'max:50'],
        ]);

        $query = Fournisseur::with(['user.image'])
            ->where('status', 1);

        if ($request->filled('is_premium')) {
            $query->where('is_premium', $request->boolean('is_premium'));
        }

        if ($request->filled('specialisation_id')) {
            $query->whereHas('agent_specialisations', function ($q) use ($request) {
                $q->where('specialisation_id', $request->integer('specialisation_id'));
            });
        }

        if ($request->filled('commune_id')) {
            $communeId = $request->integer('commune_id');
            $query->where(function ($q) use ($communeId) {
                $q->whereJsonContains('zones', $communeId)
                  ->orWhereJsonContains('zones', (string) $communeId);
            });
        }

        $perPage = min($request->integer('per_page', 15), 50);
        $agents  = $query->latest()->paginate($perPage);

        return AgentListResource::collection($agents);
    }

    /**
     * Profil complet d'un agent.
     *
     * GET /api/v1/agents/{id}
     */
    public function show(int $id): JsonResponse
    {
        $agent = Fournisseur::with([
                'user.image',
                'agent_specialisations.specialisation',
                'annonces' => fn ($q) => $q->with('images', 'commune', 'type_immo')
                                           ->where('status', 1)
                                           ->latest(),
            ])
            ->where('status', 1)
            ->findOrFail($id);

        return (new AgentResource($agent))->response();
    }
}
