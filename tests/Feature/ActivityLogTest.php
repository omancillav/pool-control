<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Membresia;
use App\Models\Clase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Activitylog\Models\Activity;

class ActivityLogTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_creation_is_logged()
    {
        $user = User::factory()->create(['name' => 'Juan Pérez']);

        $this->assertDatabaseHas('activity_log', [
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'event' => 'created',
            'log_name' => 'User'
        ]);

        $activity = Activity::where('subject_id', $user->id)
                           ->where('subject_type', User::class)
                           ->first();

        $this->assertStringContainsString('creado un usuario', $activity->description);
    }

    /** @test */
    public function user_update_is_logged()
    {
        $user = User::factory()->create(['name' => 'Original Name']);
        
        $user->update(['name' => 'Updated Name']);

        $this->assertDatabaseHas('activity_log', [
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'event' => 'updated',
            'log_name' => 'User'
        ]);

        $activity = Activity::where('subject_id', $user->id)
                           ->where('event', 'updated')
                           ->first();

        $this->assertStringContainsString('actualizado un usuario', $activity->description);
    }

    /** @test */
    public function user_deletion_is_logged()
    {
        $user = User::factory()->create();
        $userId = $user->id;
        
        $user->delete();

        $this->assertDatabaseHas('activity_log', [
            'subject_type' => User::class,
            'subject_id' => $userId,
            'event' => 'deleted',
            'log_name' => 'User'
        ]);
    }

    /** @test */
    public function membresia_creation_is_logged()
    {
        $user = User::factory()->create();
        $membresia = Membresia::factory()->create(['id_usuario' => $user->id]);

        $this->assertDatabaseHas('activity_log', [
            'subject_type' => Membresia::class,
            'subject_id' => $membresia->id,
            'event' => 'created',
            'log_name' => 'Membresia'
        ]);

        $activity = Activity::where('subject_id', $membresia->id)
                           ->where('subject_type', Membresia::class)
                           ->first();

        $this->assertStringContainsString('creado una membresía', $activity->description);
    }

    /** @test */
    public function clase_creation_is_logged()
    {
        $profesor = User::factory()->create(['rol' => 'Profesor']);
        $clase = Clase::factory()->create(['id_profesor' => $profesor->id]);

        $this->assertDatabaseHas('activity_log', [
            'subject_type' => Clase::class,
            'subject_id' => $clase->id,
            'event' => 'created',
            'log_name' => 'Clase'
        ]);

        $activity = Activity::where('subject_id', $clase->id)
                           ->where('subject_type', Clase::class)
                           ->first();

        $this->assertStringContainsString('creado una clase', $activity->description);
    }

    /** @test */
    public function activity_log_stores_fillable_attributes()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'rol' => 'Cliente'
        ]);

        $activity = Activity::where('subject_id', $user->id)
                           ->where('subject_type', User::class)
                           ->first();

        $properties = $activity->properties;
        
        $this->assertArrayHasKey('attributes', $properties);
        $this->assertEquals('Test User', $properties['attributes']['name']);
        $this->assertEquals('test@example.com', $properties['attributes']['email']);
        $this->assertEquals('Cliente', $properties['attributes']['rol']);
    }

    /** @test */
    public function can_retrieve_activity_log_for_user()
    {
        $user = User::factory()->create();
        $user->update(['name' => 'Updated Name']);
        $user->update(['email' => 'new@example.com']);

        $activities = Activity::forSubject($user)->get();

        $this->assertCount(3, $activities); // created, updated, updated
        $this->assertEquals('created', $activities[0]->event);
        $this->assertEquals('updated', $activities[1]->event);
        $this->assertEquals('updated', $activities[2]->event);
    }
}
