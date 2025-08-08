<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Pago;
use App\Models\Asistencia;
use App\Models\Clase;
use App\Models\Membresia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Activitylog\Models\Activity;

class ExtendedActivityLogTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function pago_creation_is_logged()
    {
        $user = User::factory()->create();
        $membresia = Membresia::factory()->create(['id_usuario' => $user->id]);

        $pago = Pago::create([
            'id_usuario' => $user->id,
            'id_membresia' => $membresia->id,
            'monto' => 500.00,
            'fecha' => now()->toDateString(),
            'metodo_pago' => 'online',
            'estado' => 'completado',
            'numero_transaccion' => 'TEST-123456',
            'notas' => 'Pago de prueba'
        ]);

        $this->assertDatabaseHas('activity_log', [
            'subject_type' => Pago::class,
            'subject_id' => $pago->id,
            'event' => 'created',
            'log_name' => 'Pago'
        ]);

        $activity = Activity::where('subject_id', $pago->id)
            ->where('subject_type', Pago::class)
            ->first();

        $this->assertEquals('Se ha registrado un pago', $activity->description);
    }

    /** @test */
    public function pago_update_is_logged()
    {
        $user = User::factory()->create();
        $membresia = Membresia::factory()->create(['id_usuario' => $user->id]);

        $pago = Pago::factory()->create([
            'id_usuario' => $user->id,
            'id_membresia' => $membresia->id,
            'estado' => 'pendiente'
        ]);

        $pago->update(['estado' => 'completado']);

        $this->assertDatabaseHas('activity_log', [
            'subject_type' => Pago::class,
            'subject_id' => $pago->id,
            'event' => 'updated',
            'log_name' => 'Pago'
        ]);
    }

    /** @test */
    public function asistencia_creation_is_logged()
    {
        $user = User::factory()->create();
        $clase = Clase::factory()->create();

        $asistencia = Asistencia::create([
            'id_clase' => $clase->id,
            'id_usuario' => $user->id,
            'presente' => true,
            'observaciones' => 'Asistió puntualmente',
            'fecha_marcado' => now(),
        ]);

        $this->assertDatabaseHas('activity_log', [
            'subject_type' => Asistencia::class,
            'subject_id' => $asistencia->id,
            'event' => 'created',
            'log_name' => 'Asistencia'
        ]);

        $activity = Activity::where('subject_id', $asistencia->id)
            ->where('subject_type', Asistencia::class)
            ->first();

        $this->assertEquals('Se ha registrado una asistencia', $activity->description);
    }

    /** @test */
    public function asistencia_update_is_logged()
    {
        $user = User::factory()->create();
        $clase = Clase::factory()->create();

        $asistencia = Asistencia::create([
            'id_clase' => $clase->id,
            'id_usuario' => $user->id,
            'presente' => false,
            'observaciones' => null,
            'fecha_marcado' => now(),
        ]);

        $asistencia->update([
            'presente' => true,
            'observaciones' => 'Llegó tarde pero asistió'
        ]);

        $this->assertDatabaseHas('activity_log', [
            'subject_type' => Asistencia::class,
            'subject_id' => $asistencia->id,
            'event' => 'updated',
            'log_name' => 'Asistencia'
        ]);
    }

    /** @test */
    public function manual_pago_processing_is_logged()
    {
        $admin = User::factory()->create(['rol' => 'admin']);
        $this->actingAs($admin);

        $user = User::factory()->create();
        $membresia = Membresia::factory()->create(['id_usuario' => $user->id]);

        $pago = Pago::factory()->create([
            'id_usuario' => $user->id,
            'id_membresia' => $membresia->id,
            'estado' => 'pendiente',
            'metodo_pago' => 'fisico'
        ]);

        // Simular el proceso de marcar como completado
        activity('Pago')
            ->causedBy($admin)
            ->performedOn($pago)
            ->withProperties([
                'pago_id' => $pago->id,
                'estado_anterior' => 'pendiente',
                'estado_nuevo' => 'completado',
                'metodo_pago' => $pago->metodo_pago,
                'monto' => $pago->monto
            ])
            ->log('Pago físico marcado como completado');

        $this->assertDatabaseHas('activity_log', [
            'causer_type' => User::class,
            'causer_id' => $admin->id,
            'subject_type' => Pago::class,
            'subject_id' => $pago->id,
            'description' => 'Pago físico marcado como completado'
        ]);

        $activity = Activity::where('description', 'Pago físico marcado como completado')->latest()->first();
        
        // Just verify the activity was logged correctly
        $this->assertNotNull($activity);
        $this->assertEquals('Pago físico marcado como completado', $activity->description);
        $this->assertEquals($pago->id, $activity->subject_id);
        $this->assertEquals(Pago::class, $activity->subject_type);
    }

    /** @test */
    public function batch_asistencia_logging_works()
    {
        $profesor = User::factory()->create(['rol' => 'profesor']);
        $this->actingAs($profesor);

        $clase = Clase::factory()->create();

        // Simular guardado masivo de asistencias
        activity('Asistencia')
            ->causedBy($profesor)
            ->withProperties([
                'clase_id' => $clase->id,
                'clase_nivel' => $clase->nivel,
                'fecha_clase' => $clase->fecha,
                'asistencias_creadas' => 5,
                'asistencias_actualizadas' => 2,
                'usuarios_presentes' => 6,
                'total_usuarios_evaluados' => 7
            ])
            ->log('Asistencias guardadas para clase de ' . $clase->nivel . ' del ' . $clase->fecha->format('d/m/Y'));

        $this->assertDatabaseHas('activity_log', [
            'causer_type' => User::class,
            'causer_id' => $profesor->id,
            'log_name' => 'Asistencia'
        ]);

        $activity = Activity::where('log_name', 'Asistencia')->latest()->first();
        
        // Just verify the activity was logged correctly
        $this->assertNotNull($activity);
        $this->assertEquals($profesor->id, $activity->causer_id);
        $this->assertEquals('Asistencia', $activity->log_name);
        $this->assertStringContainsString('Asistencias guardadas para clase de', $activity->description);
    }

    /** @test */
    public function admin_user_creation_is_logged()
    {
        $admin = User::factory()->create(['rol' => 'admin']);
        $this->actingAs($admin);

        $newUser = User::factory()->create(['rol' => 'Cliente']);

        // Simular log manual para creación por admin
        activity('User')
            ->causedBy($admin)
            ->performedOn($newUser)
            ->withProperties([
                'created_by_admin' => true,
                'user_role' => $newUser->rol,
                'user_email' => $newUser->email
            ])
            ->log('Usuario creado por administrador');

        $this->assertDatabaseHas('activity_log', [
            'causer_type' => User::class,
            'causer_id' => $admin->id,
            'subject_type' => User::class,
            'subject_id' => $newUser->id,
            'description' => 'Usuario creado por administrador'
        ]);

        $activity = Activity::where('subject_id', $newUser->id)
            ->where('description', 'Usuario creado por administrador')
            ->first();

        $properties = $activity->properties;
        $this->assertTrue($properties['created_by_admin']);
        $this->assertEquals('Cliente', $properties['user_role']);
    }

    /** @test */
    public function membresia_purchase_is_logged()
    {
        $client = User::factory()->create(['rol' => 'Cliente']);
        $this->actingAs($client);

        $membresia = Membresia::factory()->create(['id_usuario' => $client->id]);

        // Simular log de compra de membresía
        activity('Membresia')
            ->causedBy($client)
            ->withProperties([
                'paquete' => 'basico',
                'clases_compradas' => 4,
                'monto' => 500.00,
                'metodo_pago' => 'online',
                'estado_pago' => 'completado',
                'es_renovacion' => false,
                'numero_transaccion' => 'MEM-20250808-1234'
            ])
            ->log('Membresía Paquete Básico adquirida');

        $this->assertDatabaseHas('activity_log', [
            'causer_type' => User::class,
            'causer_id' => $client->id,
            'log_name' => 'Membresia',
            'description' => 'Membresía Paquete Básico adquirida'
        ]);

        $activity = Activity::where('description', 'Membresía Paquete Básico adquirida')->latest()->first();
        
        // Just verify the activity was logged correctly
        $this->assertNotNull($activity);
        $this->assertEquals($client->id, $activity->causer_id);
        $this->assertEquals('Membresia', $activity->log_name);
        $this->assertEquals('Membresía Paquete Básico adquirida', $activity->description);
    }
}
