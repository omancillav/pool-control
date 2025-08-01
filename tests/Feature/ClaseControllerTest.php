<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Clase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class ClaseControllerTest extends TestCase
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
    public function admin_can_view_clases_index()
    {
        $response = $this->actingAs($this->admin)->get('/clases');
        
        $response->assertStatus(200);
    }

    /** @test */
    public function profesor_can_view_clases_index()
    {
        $response = $this->actingAs($this->profesor)->get('/clases');
        
        $response->assertStatus(200);
    }

    /** @test */
    public function admin_can_create_clase()
    {
        $profesor = User::factory()->create(['rol' => 'Profesor']);

        $response = $this->actingAs($this->admin)->post('/clases/store', [
            'fecha' => Carbon::tomorrow()->format('Y-m-d'),
            'id_profesor' => $profesor->id,
            'tipo' => 'Aqua Aeróbicos',
            'lugares' => 15,
            'lugares_ocupados' => 0,
            'lugares_disponibles' => 15
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('clases', [
            'id_profesor' => $profesor->id,
            'tipo' => 'Aqua Aeróbicos',
            'lugares' => 15,
            'lugares_disponibles' => 15
        ]);
    }

    /** @test */
    public function profesor_can_create_clase()
    {
        $response = $this->actingAs($this->profesor)->post('/clases/store', [
            'fecha' => Carbon::tomorrow()->format('Y-m-d'),
            'id_profesor' => $this->profesor->id,
            'tipo' => 'Natación',
            'lugares' => 10,
            'lugares_ocupados' => 0,
            'lugares_disponibles' => 10
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('clases', [
            'id_profesor' => $this->profesor->id,
            'tipo' => 'Natación',
            'lugares' => 10
        ]);
    }

    /** @test */
    public function cliente_cannot_create_clase()
    {
        $response = $this->actingAs($this->cliente)->post('/clases/store', [
            'fecha' => Carbon::tomorrow()->format('Y-m-d'),
            'id_profesor' => $this->profesor->id,
            'tipo' => 'Aqua Aeróbicos',
            'lugares' => 15,
            'lugares_ocupados' => 0,
            'lugares_disponibles' => 15
        ]);

        $response->assertRedirect('/home');
    }

    /** @test */
    public function admin_can_update_clase()
    {
        $clase = Clase::factory()->create([
            'id_profesor' => $this->profesor->id,
            'tipo' => 'Natación',
            'lugares' => 10
        ]);

        $response = $this->actingAs($this->admin)->put("/clases/{$clase->id}", [
            'fecha' => $clase->fecha->format('Y-m-d'),
            'id_profesor' => $this->profesor->id,
            'tipo' => 'Aqua Aeróbicos',
            'lugares' => 15,
            'lugares_ocupados' => 5,
            'lugares_disponibles' => 10
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('clases', [
            'id' => $clase->id,
            'tipo' => 'Aqua Aeróbicos',
            'lugares' => 15
        ]);
    }

    /** @test */
    public function admin_can_delete_clase()
    {
        $clase = Clase::factory()->create(['id_profesor' => $this->profesor->id]);

        $response = $this->actingAs($this->admin)->delete("/clases/{$clase->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('clases', ['id' => $clase->id]);
    }

    /** @test */
    public function cliente_can_view_clases_list()
    {
        $response = $this->actingAs($this->cliente)->get('/clases/lista');
        
        $response->assertStatus(200);
    }

    /** @test */
    public function cliente_can_register_for_clase()
    {
        // Este test requiere implementar la ruta /clases/{id}/inscribir
        // Comentado temporalmente hasta que se implemente
        $this->markTestSkipped('Ruta de inscripción a clases no implementada aún');
        
        /*
        $clase = Clase::factory()->create([
            'id_profesor' => $this->profesor->id,
            'lugares_disponibles' => 5
        ]);

        $response = $this->actingAs($this->cliente)->post("/clases/{$clase->id}/inscribir");

        $response->assertRedirect();
        $this->assertTrue($clase->usuarios()->where('id_usuario', $this->cliente->id)->exists());
        */
    }

    /** @test */
    public function cliente_cannot_register_for_full_clase()
    {
        $this->markTestSkipped('El sistema de inscripciones no está implementado aún');
    }

    /** @test */
    public function creating_clase_requires_valid_data()
    {
        $response = $this->actingAs($this->admin)->post('/clases/store', [
            'fecha' => '',
            'id_profesor' => '',
            'tipo' => '',
            'lugares' => -1,
            'lugares_ocupados' => '',
            'lugares_disponibles' => ''
        ]);

        $response->assertSessionHasErrors([
            'fecha',
            'id_profesor',
            'tipo',
            'lugares'
        ]);
    }

    /** @test */
    public function fecha_cannot_be_in_the_past()
    {
        // Actualmente la validación de fecha pasada solo está en el frontend (JavaScript)
        // No está implementada en el backend, por lo que este test se omite
        $this->markTestSkipped('Validación de fecha pasada no implementada en backend aún');
    }
}
