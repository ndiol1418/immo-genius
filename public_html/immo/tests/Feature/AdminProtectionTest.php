<?php

namespace Tests\Feature;

use App\Models\User;
use App\Http\Middleware\EnsureTwoFactorAuth;
use App\Http\Middleware\TranslateMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * Tests de protection des routes admin.
 *
 * Les routes /admin/* sont protégées par :
 *   auth → 2fa → translate → role:admin (Spatie)
 *
 * On bypass EnsureTwoFactorAuth et TranslateMiddleware pour isoler
 * le comportement du middleware role:admin.
 *
 * Comportements attendus :
 *   - Visiteur non connecté      → 302 redirect vers /login
 *   - Utilisateur sans rôle admin → 403 Forbidden
 *   - Utilisateur avec rôle admin → passe le middleware (200 ou 500 selon le
 *     contrôleur, mais jamais 302/403 causé par la protection)
 */
class AdminProtectionTest extends TestCase
{
    use RefreshDatabase;

    /** Route admin simple à tester (ne nécessite pas de données complexes). */
    private const ADMIN_ROUTE = '/admin/tableau-de-bord';

    protected function setUp(): void
    {
        parent::setUp();

        // Créer le rôle 'admin' dans la table spatie_roles
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
    }

    // -------------------------------------------------------------------------
    // Visiteur non connecté
    // -------------------------------------------------------------------------

    /** @test */
    public function un_visiteur_non_connecte_est_redirige_vers_login(): void
    {
        $response = $this->get(self::ADMIN_ROUTE);

        $response->assertRedirect('/login');
    }

    /** @test */
    public function un_visiteur_non_connecte_ne_peut_pas_acces_aux_ressources_admin(): void
    {
        $routes = [
            '/admin/users',
            '/admin/annonces',
            '/admin/biens',
            '/admin/clients',
        ];

        foreach ($routes as $route) {
            $this->get($route)->assertStatus(302);
        }
    }

    // -------------------------------------------------------------------------
    // Utilisateur connecté sans rôle admin
    // -------------------------------------------------------------------------

    /** @test */
    public function un_utilisateur_sans_role_admin_obtient_un_403(): void
    {
        $user = User::factory()->create(['google2fa_enabled' => false]);

        $response = $this->actingAs($user)
            ->withoutMiddleware([EnsureTwoFactorAuth::class, TranslateMiddleware::class])
            ->get(self::ADMIN_ROUTE);

        $response->assertStatus(403);
    }

    /** @test */
    public function un_utilisateur_avec_role_client_obtient_un_403(): void
    {
        Role::create(['name' => 'client', 'guard_name' => 'web']);

        $user = User::factory()->create(['google2fa_enabled' => false]);
        $user->assignRole('client');

        $response = $this->actingAs($user)
            ->withoutMiddleware([EnsureTwoFactorAuth::class, TranslateMiddleware::class])
            ->get(self::ADMIN_ROUTE);

        $response->assertStatus(403);
    }

    /** @test */
    public function un_utilisateur_avec_role_fournisseur_obtient_un_403(): void
    {
        Role::create(['name' => 'fournisseur', 'guard_name' => 'web']);

        $user = User::factory()->create(['google2fa_enabled' => false]);
        $user->assignRole('fournisseur');

        $response = $this->actingAs($user)
            ->withoutMiddleware([EnsureTwoFactorAuth::class, TranslateMiddleware::class])
            ->get(self::ADMIN_ROUTE);

        $response->assertStatus(403);
    }

    /** @test */
    public function un_utilisateur_avec_role_gerant_obtient_un_403(): void
    {
        Role::create(['name' => 'gerant', 'guard_name' => 'web']);

        $user = User::factory()->create(['google2fa_enabled' => false]);
        $user->assignRole('gerant');

        $response = $this->actingAs($user)
            ->withoutMiddleware([EnsureTwoFactorAuth::class, TranslateMiddleware::class])
            ->get(self::ADMIN_ROUTE);

        $response->assertStatus(403);
    }

    // -------------------------------------------------------------------------
    // Utilisateur connecté avec rôle admin
    // -------------------------------------------------------------------------

    /** @test */
    public function un_admin_passe_la_protection_de_la_route(): void
    {
        $admin = User::factory()->create(['google2fa_enabled' => false]);
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)
            ->withoutMiddleware([EnsureTwoFactorAuth::class, TranslateMiddleware::class])
            ->get(self::ADMIN_ROUTE);

        // Le middleware role:admin laisse passer → pas de 403 ni de redirect login
        $this->assertNotEquals(403, $response->status());
        $this->assertNotEquals(302, $response->status());
    }

    /** @test */
    public function un_non_admin_ne_peut_pas_acceder_a_la_gestion_des_annonces(): void
    {
        $userSansRole = User::factory()->create(['google2fa_enabled' => false]);

        $this->actingAs($userSansRole)
            ->withoutMiddleware([EnsureTwoFactorAuth::class, TranslateMiddleware::class])
            ->get('/admin/annonces')
            ->assertStatus(403);
    }

    /** @test */
    public function un_admin_peut_acceder_a_la_gestion_des_annonces(): void
    {
        $admin = User::factory()->create(['google2fa_enabled' => false]);
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)
            ->withoutMiddleware([EnsureTwoFactorAuth::class, TranslateMiddleware::class])
            ->get('/admin/annonces');

        $this->assertNotEquals(403, $response->status());
        $this->assertNotEquals(302, $response->status());
    }

    /** @test */
    public function la_validation_dune_annonce_est_reservee_aux_admins(): void
    {
        $userSansRole = User::factory()->create(['google2fa_enabled' => false]);

        $response = $this->actingAs($userSansRole)
            ->withoutMiddleware([EnsureTwoFactorAuth::class, TranslateMiddleware::class])
            ->post('/admin/annonce/validate/1');

        $response->assertStatus(403);
    }
}
