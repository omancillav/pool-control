<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_access_admin_routes()
    {
        $admin = User::factory()->create(['rol' => 'Administrador']);

        $response = $this->actingAs($admin)->get('/membresias');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/usuarios');
        $response->assertStatus(200);
    }

    /** @test */
    public function profesor_can_access_profesor_routes()
    {
        $profesor = User::factory()->create(['rol' => 'Profesor']);

        $response = $this->actingAs($profesor)->get('/usuarios');
        $response->assertStatus(200);

        $response = $this->actingAs($profesor)->get('/clases');
        $response->assertStatus(200);
    }

    /** @test */
    public function cliente_can_access_cliente_routes()
    {
        $cliente = User::factory()->create(['rol' => 'Cliente']);

        $response = $this->actingAs($cliente)->get('/membresias/lista');
        $response->assertStatus(200);

        $response = $this->actingAs($cliente)->get('/clases/lista');
        $response->assertStatus(200);
    }

    /** @test */
    public function cliente_cannot_access_admin_routes()
    {
        $cliente = User::factory()->create(['rol' => 'Cliente']);

        $response = $this->actingAs($cliente)->get('/membresias');
        $response->assertRedirect('/home');

        $response = $this->actingAs($cliente)->get('/usuarios');
        $response->assertRedirect('/home');
    }

    /** @test */
    public function profesor_cannot_access_admin_only_routes()
    {
        $profesor = User::factory()->create(['rol' => 'Profesor']);

        $response = $this->actingAs($profesor)->get('/membresias');
        $response->assertRedirect('/home');
    }

    /** @test */
    public function unauthenticated_user_redirected_to_login()
    {
        $response = $this->get('/membresias');
        $response->assertRedirect('/login');

        $response = $this->get('/usuarios');
        $response->assertRedirect('/login');

        $response = $this->get('/clases');
        $response->assertRedirect('/login');
    }
}
