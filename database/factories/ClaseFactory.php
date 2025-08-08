<?php

namespace Database\Factories;

use App\Models\Clase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clase>
 */
class ClaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Clase::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $lugares = fake()->numberBetween(10, 30);
        $lugaresOcupados = fake()->numberBetween(0, $lugares);
        $lugaresDisponibles = $lugares - $lugaresOcupados;
        
        $nivel = fake()->randomElement([
            'Principiante',
            'Intermedio', 
            'Avanzado',
            'Competencia',
            'Aqua Aeróbicos',
            'Nado Sincronizado',
            'Rehabilitación',
            'Infantil'
        ]);

        return [
            'fecha' => fake()->dateTimeBetween('now', '+2 weeks'),
            'id_profesor' => User::factory(['rol' => 'Profesor']),
            'nivel' => $nivel,
            'lugares' => $lugares,
            'lugares_ocupados' => $lugaresOcupados,
            'lugares_disponibles' => $lugaresDisponibles,
        ];
    }

    /**
     * Indicate that the class is completely full.
     */
    public function completa(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'lugares_ocupados' => $attributes['lugares'],
                'lugares_disponibles' => 0,
            ];
        });
    }

    /**
     * Indicate that the class is completely empty.
     */
    public function vacia(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'lugares_ocupados' => 0,
                'lugares_disponibles' => $attributes['lugares'],
            ];
        });
    }

    /**
     * Indicate that the class is scheduled for today.
     */
    public function hoy(): static
    {
        return $this->state(fn (array $attributes) => [
            'fecha' => Carbon::today(),
        ]);
    }

    /**
     * Indicate that the class is scheduled for tomorrow.
     */
    public function manana(): static
    {
        return $this->state(fn (array $attributes) => [
            'fecha' => Carbon::tomorrow(),
        ]);
    }

    /**
     * Indicate that the class is in the past.
     */
    public function pasada(): static
    {
        return $this->state(fn (array $attributes) => [
            'fecha' => fake()->dateTimeBetween('-1 month', 'yesterday'),
        ]);
    }
}
