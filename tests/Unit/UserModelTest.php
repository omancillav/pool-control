<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Membresia;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_user()
    {
        $user = User::factory()->create([
            'name' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'rol' => 'Cliente'
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'rol' => 'Cliente'
        ]);
    }

    /** @test */
    public function it_has_fillable_attributes()
    {
        $user = new User();
        $fillable = ['name', 'email', 'password', 'rol', 'google_id', 'facebook_id', 'avatar'];
        
        $this->assertEquals($fillable, $user->getFillable());
    }

    /** @test */
    public function it_hides_sensitive_attributes()
    {
        $user = User::factory()->create();
        $hidden = $user->getHidden();
        
        $this->assertContains('password', $hidden);
        $this->assertContains('remember_token', $hidden);
    }

    /** @test */
    public function it_can_have_membresias()
    {
        $user = User::factory()->create();
        $membresia = Membresia::factory()->create(['id_usuario' => $user->id]);

        $this->assertTrue($user->membresia()->exists());
        $this->assertEquals($membresia->id, $user->membresia->id);
    }

    /** @test */
    public function it_logs_activity_when_created()
    {
        $user = User::factory()->create(['name' => 'Test User']);

        $this->assertDatabaseHas('activity_log', [
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'event' => 'created',
            'log_name' => 'User'
        ]);
    }

    /** @test */
    public function it_validates_rol_values()
    {
        $validRoles = ['Administrador', 'Profesor', 'Cliente'];
        
        foreach ($validRoles as $rol) {
            $user = User::factory()->create(['rol' => $rol]);
            $this->assertEquals($rol, $user->rol);
        }
    }
}
