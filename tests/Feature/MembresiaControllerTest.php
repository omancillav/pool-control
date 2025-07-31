<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Membresia;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MembresiaControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $cliente;
    protected User $profesor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['rol' => 'Administrador']);
        $this->cliente = User::factory()->create(['rol' => 'Cliente']);
        $this->profesor = User::factory()->create(['rol' => 'Profesor']);
    }

    /** @test */
    public function admin_can_view_membresias_index()
    {
        $response = $this->actingAs($this->admin)->get('/membresias');
        
        $response->assertStatus(200);
        $response->assertViewIs('membresias.nueva');
    }

    /** @test */
    public function cliente_cannot_view_membresias_index()
    {
        $response = $this->actingAs($this->cliente)->get('/membresias');
        
        $response->assertRedirect('/home');
    }

    /** @test */
    public function admin_can_create_membresia()
    {
        $cliente = User::factory()->create(['rol' => 'Cliente']);

        $response = $this->actingAs($this->admin)->post('/membresias/store', [
            'id_usuario' => $cliente->id,
            'clases_adquiridas' => 10,
            'clases_disponibles' => 10,
            'clases_ocupadas' => 0
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('membresias', [
            'id_usuario' => $cliente->id,
            'clases_adquiridas' => 10,
            'clases_disponibles' => 10,
            'clases_ocupadas' => 0
        ]);
    }

    /** @test */
    public function admin_can_update_membresia()
    {
        $cliente = User::factory()->create(['rol' => 'Cliente']);
        $membresia = Membresia::factory()->create([
            'id_usuario' => $cliente->id,
            'clases_adquiridas' => 10,
            'clases_disponibles' => 8,
            'clases_ocupadas' => 2
        ]);

        $response = $this->actingAs($this->admin)->put("/membresias/{$membresia->id}", [
            'id_usuario' => $cliente->id,
            'clases_adquiridas' => 15,
            'clases_disponibles' => 10,
            'clases_ocupadas' => 5
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('membresias', [
            'id' => $membresia->id,
            'clases_adquiridas' => 15,
            'clases_disponibles' => 10,
            'clases_ocupadas' => 5
        ]);
    }

    /** @test */
    public function admin_can_delete_membresia()
    {
        $cliente = User::factory()->create(['rol' => 'Cliente']);
        $membresia = Membresia::factory()->create(['id_usuario' => $cliente->id]);

        $response = $this->actingAs($this->admin)->delete("/membresias/{$membresia->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('membresias', ['id' => $membresia->id]);
    }

    /** @test */
    public function cliente_can_view_membresias_list()
    {
        $response = $this->actingAs($this->cliente)->get('/membresias/lista');
        
        $response->assertStatus(200);
        $response->assertViewIs('membresias.lista');
    }

    /** @test */
    public function membresias_index_shows_search_results()
    {
        $cliente1 = User::factory()->create(['name' => 'Juan Pérez', 'rol' => 'Cliente']);
        $cliente2 = User::factory()->create(['name' => 'María García', 'rol' => 'Cliente']);
        
        $membresia1 = Membresia::factory()->create(['id_usuario' => $cliente1->id, 'clases_adquiridas' => 10]);
        $membresia2 = Membresia::factory()->create(['id_usuario' => $cliente2->id, 'clases_adquiridas' => 20]);

        $response = $this->actingAs($this->admin)->get('/membresias?search=10');

        $response->assertStatus(200);
        $response->assertSee('10');
        $response->assertDontSee('20');
    }

    /** @test */
    public function creating_membresia_requires_valid_data()
    {
        $response = $this->actingAs($this->admin)->post('/membresias/store', [
            'id_usuario' => '',
            'clases_adquiridas' => '',
            'clases_disponibles' => '',
            'clases_ocupadas' => ''
        ]);

        $response->assertSessionHasErrors([
            'id_usuario',
            'clases_adquiridas',
            'clases_disponibles',
            'clases_ocupadas'
        ]);
    }

    /** @test */
    public function profesor_cannot_create_membresia()
    {
        $cliente = User::factory()->create(['rol' => 'Cliente']);

        $response = $this->actingAs($this->profesor)->post('/membresias/store', [
            'id_usuario' => $cliente->id,
            'clases_adquiridas' => 10,
            'clases_disponibles' => 10,
            'clases_ocupadas' => 0
        ]);

        $response->assertRedirect('/home');
    }
}
