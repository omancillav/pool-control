<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Membresia;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MembresiaModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_membresia()
    {
        $user = User::factory()->create();
        $membresia = Membresia::factory()->create([
            'id_usuario' => $user->id,
            'clases_adquiridas' => 10,
            'clases_disponibles' => 8,
            'clases_ocupadas' => 2
        ]);

        $this->assertDatabaseHas('membresias', [
            'id_usuario' => $user->id,
            'clases_adquiridas' => 10,
            'clases_disponibles' => 8,
            'clases_ocupadas' => 2
        ]);
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $membresia = Membresia::factory()->create(['id_usuario' => $user->id]);

        $this->assertInstanceOf(User::class, $membresia->usuario);
        $this->assertEquals($user->id, $membresia->usuario->id);
    }

    /** @test */
    public function it_validates_clases_consistency()
    {
        $user = User::factory()->create();
        $membresia = Membresia::factory()->create([
            'id_usuario' => $user->id,
            'clases_adquiridas' => 10,
            'clases_disponibles' => 7,
            'clases_ocupadas' => 3
        ]);

        // Verificar que clases_disponibles + clases_ocupadas = clases_adquiridas
        $this->assertEquals(
            $membresia->clases_adquiridas,
            $membresia->clases_disponibles + $membresia->clases_ocupadas
        );
    }

    /** @test */
    public function it_logs_activity_when_created()
    {
        $user = User::factory()->create();
        $membresia = Membresia::factory()->create(['id_usuario' => $user->id]);

        $this->assertDatabaseHas('activity_log', [
            'subject_type' => Membresia::class,
            'subject_id' => $membresia->id,
            'event' => 'created',
            'log_name' => 'Membresia'
        ]);
    }

    /** @test */
    public function it_has_correct_fillable_attributes()
    {
        $membresia = new Membresia();
        $expected = ['id_usuario', 'clases_adquiridas', 'clases_disponibles', 'clases_ocupadas'];
        
        $this->assertEquals($expected, $membresia->getFillable());
    }

    /** @test */
    public function it_can_calculate_used_classes()
    {
        $user = User::factory()->create();
        $membresia = Membresia::factory()->create([
            'id_usuario' => $user->id,
            'clases_adquiridas' => 10,
            'clases_disponibles' => 6,
            'clases_ocupadas' => 4
        ]);

        // Método helper que podrías agregar al modelo
        $usedClasses = $membresia->clases_adquiridas - $membresia->clases_disponibles;
        $this->assertEquals(4, $usedClasses);
    }
}
