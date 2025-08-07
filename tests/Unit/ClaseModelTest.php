<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Clase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class ClaseModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_clase()
    {
        $profesor = User::factory()->create(['rol' => 'Profesor']);
        $clase = Clase::factory()->create([
            'fecha' => Carbon::today(),
            'id_profesor' => $profesor->id,
            'nivel' => 'Avanzado',
            'lugares' => 15,
            'lugares_ocupados' => 5,
            'lugares_disponibles' => 10
        ]);

        $this->assertDatabaseHas('clases', [
            'id_profesor' => $profesor->id,
            'nivel' => 'Avanzado',
            'lugares' => 15,
            'lugares_ocupados' => 5,
            'lugares_disponibles' => 10
        ]);
    }

    /** @test */
    public function it_belongs_to_a_profesor()
    {
        $profesor = User::factory()->create(['rol' => 'Profesor']);
        $clase = Clase::factory()->create(['id_profesor' => $profesor->id]);

        $this->assertInstanceOf(User::class, $clase->profesor);
        $this->assertEquals($profesor->id, $clase->profesor->id);
        $this->assertEquals('Profesor', $clase->profesor->rol);
    }

    /** @test */
    public function it_can_have_usuarios_enrolled()
    {
        // Funcionalidad de inscripciones no implementada aún
        $this->markTestSkipped('Sistema de asistencias/inscripciones no implementado');
    }

    /** @test */
    public function it_validates_lugares_consistency()
    {
        $profesor = User::factory()->create(['rol' => 'Profesor']);
        $clase = Clase::factory()->create([
            'id_profesor' => $profesor->id,
            'lugares' => 20,
            'lugares_ocupados' => 8,
            'lugares_disponibles' => 12
        ]);

        // Verificar que lugares_ocupados + lugares_disponibles = lugares
        $this->assertEquals(
            $clase->lugares,
            $clase->lugares_ocupados + $clase->lugares_disponibles
        );
    }

    /** @test */
    public function it_casts_fecha_to_date()
    {
        $profesor = User::factory()->create(['rol' => 'Profesor']);
        $clase = Clase::factory()->create([
            'id_profesor' => $profesor->id,
            'fecha' => '2025-08-01'
        ]);

        $this->assertInstanceOf(Carbon::class, $clase->fecha);
    }

    /** @test */
    public function it_logs_activity_when_created()
    {
        $profesor = User::factory()->create(['rol' => 'Profesor']);
        $clase = Clase::factory()->create(['id_profesor' => $profesor->id]);

        $this->assertDatabaseHas('activity_log', [
            'subject_type' => Clase::class,
            'subject_id' => $clase->id,
            'event' => 'created',
            'log_name' => 'Clase'
        ]);
    }

    /** @test */
    public function it_has_correct_fillable_attributes()
    {
        $clase = new Clase();
        $expected = ['fecha', 'id_profesor', 'nivel', 'lugares', 'lugares_ocupados', 'lugares_disponibles'];
        
        $this->assertEquals($expected, $clase->getFillable());
    }

    /** @test */
    public function it_can_check_if_has_available_spots()
    {
        $profesor = User::factory()->create(['rol' => 'Profesor']);
        $clase = Clase::factory()->create([
            'id_profesor' => $profesor->id,
            'lugares_disponibles' => 5
        ]);

        $this->assertTrue($clase->lugares_disponibles > 0);
    }

    /** @test */
    public function it_can_check_if_is_full()
    {
        $profesor = User::factory()->create(['rol' => 'Profesor']);
        $clase = Clase::factory()->create([
            'id_profesor' => $profesor->id,
            'lugares_disponibles' => 0
        ]);

        $this->assertEquals(0, $clase->lugares_disponibles);
    }
}
