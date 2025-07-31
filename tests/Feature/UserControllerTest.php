<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $profesor;
    protected User $cliente;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['rol' => 'Administrador']);
        $this->profesor = User::factory()->create(['rol' => 'Profesor']);
        $this->cliente = User::factory()->create(['rol' => 'Cliente']);
    }

    /** @test */
    public function admin_can_view_usuarios_index()
    {
        $response = $this->actingAs($this->admin)->get('/usuarios');
        
        $response->assertStatus(200);
        $response->assertViewIs('usuarios.nueva');
    }

    /** @test */
    public function profesor_can_view_usuarios_index()
    {
        $response = $this->actingAs($this->profesor)->get('/usuarios');
        
        $response->assertStatus(200);
        $response->assertViewIs('usuarios.nueva');
    }

    /** @test */
    public function cliente_cannot_view_usuarios_index()
    {
        $response = $this->actingAs($this->cliente)->get('/usuarios');
        
        $response->assertRedirect('/home');
    }

    /** @test */
    public function admin_can_create_user()
    {
        $response = $this->actingAs($this->admin)->post('/usuarios/store', [
            'name' => 'Nuevo Usuario',
            'email' => 'nuevo@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'rol' => 'Cliente'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'name' => 'Nuevo Usuario',
            'email' => 'nuevo@example.com',
            'rol' => 'Cliente'
        ]);
    }

    /** @test */
    public function profesor_can_create_user()
    {
        $response = $this->actingAs($this->profesor)->post('/usuarios/store', [
            'name' => 'Cliente Nuevo',
            'email' => 'cliente@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'rol' => 'Cliente'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'name' => 'Cliente Nuevo',
            'email' => 'cliente@example.com',
            'rol' => 'Cliente'
        ]);
    }

    /** @test */
    public function admin_can_update_user()
    {
        $user = User::factory()->create([
            'name' => 'Usuario Original',
            'email' => 'original@example.com',
            'rol' => 'Cliente'
        ]);

        $response = $this->actingAs($this->admin)->put("/usuarios/{$user->id}", [
            'name' => 'Usuario Actualizado',
            'email' => 'actualizado@example.com',
            'rol' => 'Profesor'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Usuario Actualizado',
            'email' => 'actualizado@example.com',
            'rol' => 'Profesor'
        ]);
    }

    /** @test */
    public function admin_can_delete_user()
    {
        $user = User::factory()->create(['rol' => 'Cliente']);

        $response = $this->actingAs($this->admin)->delete("/usuarios/{$user->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function creating_user_requires_valid_data()
    {
        $response = $this->actingAs($this->admin)->post('/usuarios/store', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => '123',
            'password_confirmation' => '456',
            'rol' => 'InvalidRole'
        ]);

        $response->assertSessionHasErrors([
            'name',
            'email',
            'password'
        ]);
    }

    /** @test */
    public function email_must_be_unique()
    {
        $existingUser = User::factory()->create(['email' => 'existing@example.com']);

        $response = $this->actingAs($this->admin)->post('/usuarios/store', [
            'name' => 'Nuevo Usuario',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'rol' => 'Cliente'
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function usuarios_list_shows_search_results()
    {
        $user1 = User::factory()->create(['name' => 'Juan Pérez']);
        $user2 = User::factory()->create(['name' => 'María García']);

        $response = $this->actingAs($this->admin)->get('/usuarios/lista?search=Juan');

        $response->assertStatus(200);
        $response->assertSee('Juan Pérez');
        $response->assertDontSee('María García');
    }

    /** @test */
    public function cliente_cannot_create_users()
    {
        $response = $this->actingAs($this->cliente)->post('/usuarios/store', [
            'name' => 'Nuevo Usuario',
            'email' => 'nuevo@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'rol' => 'Cliente'
        ]);

        $response->assertRedirect('/home');
    }
}
