<?php

namespace Tests\Feature;

use App\Models\Annonce;
use App\Scopes\AnnonceScope;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests d'affichage de la liste des annonces.
 *
 * Les routes /acheter et /louer passent par AccueilController qui lit
 * communes.json. Le setUp() crée un fichier minimal si absent.
 *
 * Les annonces sont créées sans immo_id (FK désactivé en SQLite test) pour
 * isoler uniquement le comportement du listing.
 */
class AnnonceListTest extends TestCase
{
    use RefreshDatabase;

    private bool $communesJsonCreated = false;

    protected function setUp(): void
    {
        parent::setUp();

        if (! file_exists(base_path('communes.json'))) {
            file_put_contents(base_path('communes.json'), json_encode([]));
            $this->communesJsonCreated = true;
        }
    }

    protected function tearDown(): void
    {
        if ($this->communesJsonCreated) {
            @unlink(base_path('communes.json'));
        }

        parent::tearDown();
    }

    // -------------------------------------------------------------------------
    // Affichage de base
    // -------------------------------------------------------------------------

    /** @test */
    public function la_liste_acheter_saffiche_sans_annonces(): void
    {
        $response = $this->get('/acheter');

        $response->assertStatus(200);
        $response->assertViewIs('template.pages.locations');
    }

    /** @test */
    public function la_liste_louer_saffiche_sans_annonces(): void
    {
        $response = $this->get('/louer');

        $response->assertStatus(200);
        $response->assertViewIs('template.pages.locations');
    }

    // -------------------------------------------------------------------------
    // Présence des annonces dans la vue
    // -------------------------------------------------------------------------

    /** @test */
    public function les_annonces_a_vendre_apparaissent_dans_la_liste_acheter(): void
    {
        // type_location_id=1 → achat (convention de l'application)
        Annonce::withoutGlobalScope(AnnonceScope::class)->create([
            'name'             => 'Villa Dakar Test',
            'adresse'          => 'Plateau, Dakar',
            'description'      => 'Magnifique villa',
            'prix'             => 75_000_000,
            'slug'             => 'villa-dakar-test-1',
            'status'           => 1,
            'type_location_id' => 1,
        ]);

        $response = $this->get('/acheter');

        $response->assertStatus(200);
        $response->assertViewHas('annonces', function ($annonces) {
            return $annonces->contains('name', 'Villa Dakar Test');
        });
    }

    /** @test */
    public function les_annonces_a_louer_apparaissent_dans_la_liste_louer(): void
    {
        // type_location_id=2 → location (convention de l'application)
        Annonce::withoutGlobalScope(AnnonceScope::class)->create([
            'name'             => 'Appartement Plateau Location',
            'adresse'          => 'Plateau, Dakar',
            'description'      => 'Bel appartement',
            'prix'             => 500_000,
            'slug'             => 'appartement-plateau-1',
            'status'           => 1,
            'type_location_id' => 2,
        ]);

        $response = $this->get('/louer');

        $response->assertStatus(200);
        $response->assertViewHas('annonces', function ($annonces) {
            return $annonces->contains('name', 'Appartement Plateau Location');
        });
    }

    /** @test */
    public function les_annonces_achat_nappa_raissent_pas_dans_la_liste_louer(): void
    {
        Annonce::withoutGlobalScope(AnnonceScope::class)->create([
            'name'             => 'Terrain à vendre',
            'adresse'          => 'Thiès',
            'description'      => 'Grand terrain',
            'prix'             => 10_000_000,
            'slug'             => 'terrain-a-vendre-1',
            'status'           => 1,
            'type_location_id' => 1, // achat
        ]);

        $response = $this->get('/louer');

        $response->assertViewHas('annonces', function ($annonces) {
            return ! $annonces->contains('name', 'Terrain à vendre');
        });
    }

    // -------------------------------------------------------------------------
    // Filtrage par type
    // -------------------------------------------------------------------------

    /** @test */
    public function le_filtre_par_type_immo_est_pris_en_compte(): void
    {
        Annonce::withoutGlobalScope(AnnonceScope::class)->create([
            'name'             => 'Studio type 1',
            'adresse'          => 'Dakar',
            'description'      => 'Studio',
            'prix'             => 200_000,
            'slug'             => 'studio-type-1',
            'status'           => 1,
            'type_location_id' => 1,
            'type_immo_id'     => 1,
        ]);

        Annonce::withoutGlobalScope(AnnonceScope::class)->create([
            'name'             => 'Duplex type 2',
            'adresse'          => 'Dakar',
            'description'      => 'Duplex',
            'prix'             => 500_000,
            'slug'             => 'duplex-type-2',
            'status'           => 1,
            'type_location_id' => 1,
            'type_immo_id'     => 2,
        ]);

        $response = $this->get('/acheter?type=1');

        $response->assertStatus(200);
        $response->assertViewHas('annonces', function ($annonces) {
            return $annonces->contains('name', 'Studio type 1')
                && ! $annonces->contains('name', 'Duplex type 2');
        });
    }
}
