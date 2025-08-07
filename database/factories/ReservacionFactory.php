<?php

namespace Database\Factories;

use App\Models\Clase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservacion>
 */
class ReservacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_clase' => Clase::factory(),
            'id_usuario' => User::factory()->create(['rol' => 'Cliente']),
            'notas' => $this->faker->optional(0.3)->sentence(),
        ];
    }
}
