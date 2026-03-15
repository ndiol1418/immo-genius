<?php

namespace Tests\Feature;

use App\Models\Annonce;
use App\Scopes\AnnonceScope;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests de la recherche d'annonces.
 *
 * Les routes POST /search et POST /search-more passent par SearchController,
 * pas par AccueilController. Aucun communes.json requis.
 *
 * AnnonceScope n'est pas actif pour les utilisateurs non connectés :
 * les tests s'exécutent sans authentification.
 */
class SearchAnnonceTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Crée une annonce active prête à être retrouvée par la recherche.
     */
    private function creerAnnonce(array $attrs = []): Annonce
    {
        return Annonce::withoutGlobalScope(AnnonceScope::class)->create(array_merge([
            'name'             => 'Annonce Test',
            'adresse'          => 'Dakar, Plateau',
            'description'      => 'Description test',
            'prix'             => 50_000_000,
            'slug'             => 'annonce-test-' . uniqid(),
            'status'           => 1,
            'type_location_id' => 1,
            'superficie'       => 100,
            'chambres'         => 3,
            'toillettes'       => 2,
            'meubles'          => 0,
        ], $attrs));
    }

    // -------------------------------------------------------------------------
    // search-more (filtres avancés)
    // -------------------------------------------------------------------------

    /** @test */
    public function search_more_retourne_la_vue_locations(): void
    {
        $response = $this->post('/search-more', []);

        $response->assertStatus(200);
        $response->assertViewIs('template.pages.locations');
    }

    /** @test */
    public function search_more_retourne_toutes_les_annonces_sans_filtre(): void
    {
        $this->creerAnnonce(['name' => 'Annonce A']);
        $this->creerAnnonce(['name' => 'Annonce B']);

        $response = $this->post('/search-more', []);

        $response->assertViewHas('annonces', function ($annonces) {
            return $annonces->count() === 2;
        });
    }

    /** @test */
    public function search_more_filtre_par_type_location(): void
    {
        $this->creerAnnonce(['name' => 'À vendre',  'type_location_id' => 1]);
        $this->creerAnnonce(['name' => 'À louer',   'type_location_id' => 2]);

        $response = $this->post('/search-more', ['type_location_id' => 1]);

        $response->assertViewHas('annonces', function ($annonces) {
            return $annonces->contains('name', 'À vendre')
                && ! $annonces->contains('name', 'À louer');
        });
    }

    /** @test */
    public function search_more_filtre_par_nombre_de_chambres(): void
    {
        $this->creerAnnonce(['name' => '2 chambres', 'chambres' => 2]);
        $this->creerAnnonce(['name' => '4 chambres', 'chambres' => 4]);

        $response = $this->post('/search-more', ['chambres' => 2]);

        $response->assertViewHas('annonces', function ($annonces) {
            return $annonces->contains('name', '2 chambres')
                && ! $annonces->contains('name', '4 chambres');
        });
    }

    /** @test */
    public function search_more_filtre_par_nombre_de_toillettes(): void
    {
        $this->creerAnnonce(['name' => '1 toillette',  'toillettes' => 1]);
        $this->creerAnnonce(['name' => '3 toillettes', 'toillettes' => 3]);

        $response = $this->post('/search-more', ['toillettes' => 1]);

        $response->assertViewHas('annonces', function ($annonces) {
            return $annonces->contains('name', '1 toillette')
                && ! $annonces->contains('name', '3 toillettes');
        });
    }

    /** @test */
    public function search_more_filtre_par_superficie_minimale(): void
    {
        $this->creerAnnonce(['name' => 'Petit 50m2',    'superficie' => 50]);
        $this->creerAnnonce(['name' => 'Grand 200m2',   'superficie' => 200]);

        $response = $this->post('/search-more', ['min_size' => 100]);

        $response->assertViewHas('annonces', function ($annonces) {
            return $annonces->contains('name', 'Grand 200m2')
                && ! $annonces->contains('name', 'Petit 50m2');
        });
    }

    /** @test */
    public function search_more_filtre_par_superficie_maximale(): void
    {
        $this->creerAnnonce(['name' => 'Petit 50m2',  'superficie' => 50]);
        $this->creerAnnonce(['name' => 'Grand 300m2', 'superficie' => 300]);

        $response = $this->post('/search-more', ['max_size' => 100]);

        $response->assertViewHas('annonces', function ($annonces) {
            return $annonces->contains('name', 'Petit 50m2')
                && ! $annonces->contains('name', 'Grand 300m2');
        });
    }

    /** @test */
    public function search_more_filtre_les_annonces_meublees(): void
    {
        $this->creerAnnonce(['name' => 'Meublé',     'meubles' => 1]);
        $this->creerAnnonce(['name' => 'Non meublé', 'meubles' => 0]);

        $response = $this->post('/search-more', ['meuble' => 1]);

        $response->assertViewHas('annonces', function ($annonces) {
            return $annonces->contains('name', 'Meublé')
                && ! $annonces->contains('name', 'Non meublé');
        });
    }

    /** @test */
    public function search_more_filtre_par_type_immo(): void
    {
        $this->creerAnnonce(['name' => 'Type 1', 'type_immo_id' => 1]);
        $this->creerAnnonce(['name' => 'Type 2', 'type_immo_id' => 2]);

        $response = $this->post('/search-more', ['type_immo_id' => [1]]);

        $response->assertViewHas('annonces', function ($annonces) {
            return $annonces->contains('name', 'Type 1')
                && ! $annonces->contains('name', 'Type 2');
        });
    }

    /** @test */
    public function search_more_sans_resultats_retourne_collection_vide(): void
    {
        // Aucune annonce en base → aucun résultat
        $response = $this->post('/search-more', ['chambres' => 99]);

        $response->assertViewHas('annonces', function ($annonces) {
            return $annonces->isEmpty();
        });
    }
}
