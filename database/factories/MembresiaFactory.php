<?php

namespace Database\Factories;

use App\Models\Membresia;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Membresia>
 */
class MembresiaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Membresia::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $clasesAdquiridas = fake()->numberBetween(5, 30);
        $clasesOcupadas = fake()->numberBetween(0, $clasesAdquiridas);
        $clasesDisponibles = $clasesAdquiridas - $clasesOcupadas;

        return [
            'id_usuario' => User::factory(),
            'clases_adquiridas' => $clasesAdquiridas,
            'clases_disponibles' => $clasesDisponibles,
            'clases_ocupadas' => $clasesOcupadas,
        ];
    }

    /**
     * Indicate that the membership has no available classes.
     */
    public function agotada(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'clases_disponibles' => 0,
                'clases_ocupadas' => $attributes['clases_adquiridas'],
            ];
        });
    }

    /**
     * Indicate that the membership is completely unused.
     */
    public function nueva(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'clases_disponibles' => $attributes['clases_adquiridas'],
                'clases_ocupadas' => 0,
            ];
        });
    }
}
