<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnnonceListResource;
use App\Http\Resources\AnnonceResource;
use App\Models\Annonce;
use App\Scopes\AnnonceScope;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AnnonceController extends Controller
{
    /**
     * Liste paginée des annonces actives.
     *
     * GET /api/v1/annonces
     *
     * Filtres optionnels (query params) :
     *   - type_location_id  : 1=vente, 2=location
     *   - type_immo_id      : id du type de bien
     *   - commune_id        : id de la commune
     *   - is_premium        : true|false
     *   - per_page          : taille de page (défaut: 15, max: 50)
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $request->validate([
            'type_location_id' => ['nullable', 'integer'],
            'type_immo_id'     => ['nullable', 'integer'],
            'commune_id'       => ['nullable', 'integer'],
            'is_premium'       => ['nullable', 'boolean'],
            'per_page'         => ['nullable', 'integer', 'min:1', 'max:50'],
        ]);

        $query = Annonce::withoutGlobalScope(AnnonceScope::class)
            ->with(['images', 'commune', 'type_immo'])
            ->where('status', 1)
            ->latest();

        if ($request->filled('type_location_id')) {
            $query->where('type_location_id', $request->integer('type_location_id'));
        }

        if ($request->filled('type_immo_id')) {
            $query->where('type_immo_id', $request->integer('type_immo_id'));
        }

        if ($request->filled('commune_id')) {
            $query->where('commune_id', $request->integer('commune_id'));
        }

        if ($request->filled('is_premium')) {
            $query->where('is_premium', $request->boolean('is_premium'));
        }

        $perPage = min($request->integer('per_page', 15), 50);
        $annonces = $query->paginate($perPage);

        return AnnonceListResource::collection($annonces);
    }

    /**
     * Détail complet d'une annonce.
     *
     * GET /api/v1/annonces/{id}
     */
    public function show(int $id): JsonResponse
    {
        $annonce = Annonce::withoutGlobalScope(AnnonceScope::class)
            ->with([
                'images',
                'commune.departement',
                'type_immo',
                'immo.fournisseur.user.image',
            ])
            ->where('status', 1)
            ->findOrFail($id);

        return (new AnnonceResource($annonce))->response();
    }

    /**
     * Recherche avancée d'annonces.
     *
     * POST /api/v1/search
     *
     * Body (JSON) :
     *   - adresse           : string  — recherche textuelle sur l'adresse
     *   - type_location_id  : int     — 1=vente, 2=location
     *   - type_immo_id      : int[]   — un ou plusieurs types de biens
     *   - commune_id        : int
     *   - min_prix          : int
     *   - max_prix          : int
     *   - chambres          : int
     *   - toillettes        : int
     *   - superficie_min    : int
     *   - superficie_max    : int
     *   - meubles           : bool
     *   - visite_virtuelle  : bool
     *   - per_page          : int     — défaut 15, max 50
     */
    public function search(Request $request): AnonymousResourceCollection
    {
        $request->validate([
            'adresse'          => ['nullable', 'string', 'max:255'],
            'type_location_id' => ['nullable', 'integer'],
            'type_immo_id'     => ['nullable', 'array'],
            'type_immo_id.*'   => ['integer'],
            'commune_id'       => ['nullable', 'integer'],
            'min_prix'         => ['nullable', 'integer', 'min:0'],
            'max_prix'         => ['nullable', 'integer', 'min:0'],
            'chambres'         => ['nullable', 'integer', 'min:0'],
            'toillettes'       => ['nullable', 'integer', 'min:0'],
            'superficie_min'   => ['nullable', 'integer', 'min:0'],
            'superficie_max'   => ['nullable', 'integer', 'min:0'],
            'meubles'          => ['nullable', 'boolean'],
            'visite_virtuelle' => ['nullable', 'boolean'],
            'per_page'         => ['nullable', 'integer', 'min:1', 'max:50'],
        ]);

        $query = Annonce::withoutGlobalScope(AnnonceScope::class)
            ->with(['images', 'commune', 'type_immo'])
            ->where('status', 1);

        if ($request->filled('adresse')) {
            $query->where('adresse', 'LIKE', '%' . $request->adresse . '%');
        }

        if ($request->filled('type_location_id')) {
            $query->where('type_location_id', $request->integer('type_location_id'));
        }

        if ($request->filled('type_immo_id')) {
            $query->whereIn('type_immo_id', $request->array('type_immo_id'));
        }

        if ($request->filled('commune_id')) {
            $query->where('commune_id', $request->integer('commune_id'));
        }

        if ($request->filled('min_prix')) {
            $query->where('prix', '>=', $request->integer('min_prix'));
        }

        if ($request->filled('max_prix')) {
            $query->where('prix', '<=', $request->integer('max_prix'));
        }

        if ($request->filled('chambres')) {
            $query->where('chambres', $request->integer('chambres'));
        }

        if ($request->filled('toillettes')) {
            $query->where('toillettes', $request->integer('toillettes'));
        }

        if ($request->filled('superficie_min')) {
            $query->where('superficie', '>=', $request->integer('superficie_min'));
        }

        if ($request->filled('superficie_max')) {
            $query->where('superficie', '<=', $request->integer('superficie_max'));
        }

        if ($request->filled('meubles')) {
            $query->where('meubles', $request->boolean('meubles'));
        }

        if ($request->filled('visite_virtuelle')) {
            $query->where('visite_virtuelle', $request->boolean('visite_virtuelle'));
        }

        $perPage  = min($request->integer('per_page', 15), 50);
        $annonces = $query->latest()->paginate($perPage);

        return AnnonceListResource::collection($annonces);
    }
}
