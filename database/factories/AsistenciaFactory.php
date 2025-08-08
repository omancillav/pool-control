<?php

namespace Database\Factories;

use App\Models\Asistencia;
use App\Models\User;
use App\Models\Clase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asistencia>
 */
class AsistenciaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Asistencia::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_clase' => Clase::factory(),
            'id_usuario' => User::factory(),
            'presente' => $this->faker->boolean(80), // 80% de probabilidad de estar presente
            'observaciones' => $this->faker->optional(0.3)->sentence(), // 30% de probabilidad de tener observaciones
            'fecha_marcado' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }

    /**
     * Estado para asistencia presente
     */
    public function presente(): static
    {
        return $this->state(fn (array $attributes) => [
            'presente' => true,
        ]);
    }

    /**
     * Estado para asistencia ausente
     */
    public function ausente(): static
    {
        return $this->state(fn (array $attributes) => [
            'presente' => false,
            'observaciones' => $this->faker->optional(0.5)->randomElement([
                'No asistió',
                'Enfermo',
                'Viaje de trabajo',
                'Emergencia familiar'
            ]),
        ]);
    }

    /**
     * Estado con observaciones específicas
     */
    public function conObservaciones(string $observacion = null): static
    {
        return $this->state(fn (array $attributes) => [
            'observaciones' => $observacion ?? $this->faker->sentence(),
        ]);
    }
}
