<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests des pages publiques de base.
 *
 * Prérequis : AccueilController::__construct() lit communes.json depuis la
 * racine du projet. Le setUp() crée un fichier minimal si absent et le supprime
 * après les tests.
 */
class AccueilTest extends TestCase
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

    /** @test */
    public function la_page_accueil_retourne_un_statut_200(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function la_page_accueil_utilise_la_vue_welcome(): void
    {
        $response = $this->get('/');

        $response->assertViewIs('welcome');
    }

    /** @test */
    public function la_page_accueil_expose_les_variables_attendues(): void
    {
        $response = $this->get('/');

        $response->assertViewHasAll([
            'types',
            'type_immos',
            'annonce_news',
            'annonce_premium',
            'agents',
            'regions',
            'type_locations',
        ]);
    }

    /** @test */
    public function la_page_acheter_retourne_un_statut_200(): void
    {
        $response = $this->get('/acheter');

        $response->assertStatus(200);
    }

    /** @test */
    public function la_page_acheter_utilise_la_vue_locations(): void
    {
        $response = $this->get('/acheter');

        $response->assertViewIs('template.pages.locations');
    }

    /** @test */
    public function la_page_louer_retourne_un_statut_200(): void
    {
        $response = $this->get('/louer');

        $response->assertStatus(200);
    }

    /** @test */
    public function la_page_louer_utilise_la_vue_locations(): void
    {
        $response = $this->get('/louer');

        $response->assertViewIs('template.pages.locations');
    }

    /** @test */
    public function la_page_cgu_retourne_un_statut_200(): void
    {
        $response = $this->get('/cgu');

        $response->assertStatus(200);
        $response->assertViewIs('template.pages.cgu');
    }

    /** @test */
    public function la_page_faq_retourne_un_statut_200(): void
    {
        $response = $this->get('/faq');

        $response->assertStatus(200);
        $response->assertViewIs('template.pages.faq');
    }
}
