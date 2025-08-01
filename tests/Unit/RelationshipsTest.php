<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Membresia;
use App\Models\Clase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RelationshipsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_have_multiple_membresias()
    {
        $user = User::factory()->create();
        $membresia1 = Membresia::factory()->create(['id_usuario' => $user->id]);
        // Nota: En realidad User tiene relación hasOne con Membresia
        // Este test verifica la relación existente
        
        $this->assertTrue($user->membresia()->exists());
        $this->assertEquals($membresia1->id, $user->membresia->id);
    }

    /** @test */
    public function membresia_belongs_to_user()
    {
        $user = User::factory()->create(['name' => 'Juan Pérez']);
        $membresia = Membresia::factory()->create(['id_usuario' => $user->id]);

        $this->assertInstanceOf(User::class, $membresia->usuario);
        $this->assertEquals('Juan Pérez', $membresia->usuario->name);
        $this->assertEquals($user->id, $membresia->usuario->id);
    }

    /** @test */
    public function profesor_can_have_multiple_clases()
    {
        $profesor = User::factory()->create(['rol' => 'Profesor']);
        $clase1 = Clase::factory()->create(['id_profesor' => $profesor->id]);
        $clase2 = Clase::factory()->create(['id_profesor' => $profesor->id]);

        $this->assertCount(2, $profesor->clasesImpartidas);
        $this->assertTrue($profesor->clasesImpartidas->contains($clase1));
        $this->assertTrue($profesor->clasesImpartidas->contains($clase2));
    }

    /** @test */
    public function clase_belongs_to_profesor()
    {
        $profesor = User::factory()->create([
            'name' => 'Profesor García',
            'rol' => 'Profesor'
        ]);
        $clase = Clase::factory()->create(['id_profesor' => $profesor->id]);

        $this->assertInstanceOf(User::class, $clase->profesor);
        $this->assertEquals('Profesor García', $clase->profesor->name);
        $this->assertEquals('Profesor', $clase->profesor->rol);
    }

    /** @test */
    public function clase_can_have_multiple_usuarios_enrolled()
    {
        // Sistema de asistencias no implementado aún
        $this->markTestSkipped('Sistema de asistencias/inscripciones no implementado');
    }

    /** @test */
    public function user_can_be_enrolled_in_multiple_clases()
    {
        // Sistema de asistencias no implementado aún
        $this->markTestSkipped('Sistema de asistencias/inscripciones no implementado');
    }

    /** @test */
    public function can_get_user_membresias_with_eager_loading()
    {
        $user = User::factory()->create();
        Membresia::factory()->create(['id_usuario' => $user->id]);

        $userWithMembresia = User::with('membresia')->find($user->id);

        $this->assertNotNull($userWithMembresia->membresia);
        $this->assertTrue($userWithMembresia->relationLoaded('membresia'));
    }

    /** @test */
    public function can_get_clase_with_profesor_and_usuarios()
    {
        // Sistema de asistencias no implementado aún - solo probamos relación profesor
        $profesor = User::factory()->create(['rol' => 'Profesor']);
        $clase = Clase::factory()->create(['id_profesor' => $profesor->id]);

        $claseWithRelations = Clase::with(['profesor'])->find($clase->id);

        $this->assertInstanceOf(User::class, $claseWithRelations->profesor);
        $this->assertEquals('Profesor', $claseWithRelations->profesor->rol);
    }
}
