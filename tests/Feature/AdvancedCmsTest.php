<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdvancedCmsTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_shows_category_and_offer_ctas(): void
    {
        $this->seed();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Vezi produse');
        $response->assertSee('Cere ofertă');
        $response->assertSee('Acasă');
        $response->assertSee('Despre noi');
        $response->assertSee('Contact');
    }

    public function test_admin_dashboard_redirects_to_login_for_guests(): void
    {
        $response = $this->get('/admin');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_admin_dashboard_is_available_for_authenticated_users(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Dashboard admin');
    }

    public function test_about_contact_and_quote_pages_are_available(): void
    {
        $this->seed();

        $this->get('/despre-noi')->assertStatus(200)->assertSee('Despre noi');
        $this->get('/contact')->assertStatus(200)->assertSee('Contact');
        $this->get('/cere-oferta')->assertStatus(200)->assertSee('Cere ofertă');
    }
}
