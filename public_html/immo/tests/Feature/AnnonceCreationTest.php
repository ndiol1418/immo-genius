<?php

namespace Tests\Feature;

use App\Models\Annonce;
use App\Models\User;
use App\Scopes\AnnonceScope;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests de création d'annonces.
 *
 * La route POST /publier passe par AccueilController (lecture de communes.json
 * dans le constructeur). Le setUp() crée un fichier minimal si absent.
 *
 * La création d'Immo + Annonce utilise des FK sans enregistrements parents
 * (SQLite en mode test avec DB_FOREIGN_KEYS=false).
 */
class AnnonceCreationTest extends TestCase
{
    use RefreshDatabase;

    private bool $communesJsonCreated = false;

    /** Payload minimal valide pour publierAnnonce(). */
    private function payload(array $overrides = []): array
    {
        return array_merge_recursive([
            'immo' => [
                'name'             => 'Villa Test Création',
                'montant'          => 75_000_000,
                'superficie'       => 120,
                'type_immo_id'     => 1,
                'type_location_id' => 1,
                'level_id'         => 1,
            ],
            'type_location_id'  => 1,
            'adresse'           => 'Almadies, Dakar',
            'level_id'          => 1,
            'description'       => 'Belle villa avec piscine',
            'date_disponibilite'=> '2026-06-01',
            'meuble'            => 0,
            'pieces'            => [
                1 => ['Chambres'   => 3],
                2 => ['Salons'     => 1],
                3 => ['Toillettes' => 2],
                4 => ['Cuisines'   => 1],
            ],
            'comodites'         => [],
            'images'            => [],
            'commune_id'        => null,
            'departement_id'    => null,
            'lat'               => '14.6928',
            'lon'               => '-17.4467',
            'url_video'         => null,
            'visite_virtuelle'  => null,
        ], $overrides);
    }

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
    // Formulaire de publication
    // -------------------------------------------------------------------------

    /** @test */
    public function un_utilisateur_non_connecte_voit_le_formulaire_inscription(): void
    {
        $response = $this->get('/inscriptions');

        $response->assertStatus(200);
        $response->assertViewIs('template.pages.inscription');
    }

    /** @test */
    public function un_utilisateur_connecte_voit_le_formulaire_de_publication(): void
    {
        // google2fa_enabled non défini → EnsureTwoFactorAuth laisse passer
        $user = User::factory()->create(['google2fa_enabled' => false]);

        $response = $this->actingAs($user)->get('/inscriptions');

        $response->assertStatus(200);
        $response->assertViewIs('template.pages.publication');
    }

    // -------------------------------------------------------------------------
    // Création
    // -------------------------------------------------------------------------

    /** @test */
    public function un_utilisateur_connecte_peut_creer_une_annonce(): void
    {
        $user = User::factory()->create(['google2fa_enabled' => false]);

        $response = $this->actingAs($user)->post('/publier', $this->payload());

        // Le contrôleur redirige vers la page de l'annonce après création
        $response->assertStatus(302);
        $response->assertRedirectContains('/annonces/');
    }

    /** @test */
    public function la_creation_dune_annonce_persiste_en_base(): void
    {
        $user = User::factory()->create(['google2fa_enabled' => false]);

        $this->actingAs($user)->post('/publier', $this->payload());

        $this->assertDatabaseHas('annonces', [
            'adresse' => 'Almadies, Dakar',
            'status'  => 2, // statut "en attente de validation"
        ]);
    }

    /** @test */
    public function la_creation_dune_annonce_persiste_limmo_associe(): void
    {
        $user = User::factory()->create(['google2fa_enabled' => false]);

        $this->actingAs($user)->post('/publier', $this->payload());

        $this->assertDatabaseHas('immos', [
            'name'    => 'Villa Test Création',
            'montant' => 75_000_000,
        ]);
    }

    /** @test */
    public function le_slug_de_lannonce_est_genere_automatiquement(): void
    {
        $user = User::factory()->create(['google2fa_enabled' => false]);

        $this->actingAs($user)->post('/publier', $this->payload());

        $annonce = Annonce::withoutGlobalScope(AnnonceScope::class)
            ->where('adresse', 'Almadies, Dakar')
            ->first();

        $this->assertNotNull($annonce);
        $this->assertNotEmpty($annonce->slug);
        $this->assertStringContainsString('villa-test', $annonce->slug);
    }

    /** @test */
    public function lannonce_creee_a_le_statut_en_attente(): void
    {
        $user = User::factory()->create(['google2fa_enabled' => false]);

        $this->actingAs($user)->post('/publier', $this->payload());

        $annonce = Annonce::withoutGlobalScope(AnnonceScope::class)
            ->where('adresse', 'Almadies, Dakar')
            ->first();

        // status=2 = en attente de validation par un admin
        $this->assertEquals(2, $annonce->status);
    }

    /** @test */
    public function le_nombre_de_chambres_est_correctement_enregistre(): void
    {
        $user = User::factory()->create(['google2fa_enabled' => false]);

        $this->actingAs($user)->post('/publier', $this->payload([
            'pieces' => [
                1 => ['Chambres'   => 4],
                2 => ['Salons'     => 2],
                3 => ['Toillettes' => 3],
                4 => ['Cuisines'   => 1],
            ],
        ]));

        $this->assertDatabaseHas('annonces', ['chambres' => 4]);
    }
}
