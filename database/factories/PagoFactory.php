<?php

namespace Database\Factories;

use App\Models\Pago;
use App\Models\User;
use App\Models\Membresia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pago>
 */
class PagoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pago::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $metodoPago = $this->faker->randomElement(['online', 'fisico']);
        $estado = $metodoPago === 'online' ? 'completado' : $this->faker->randomElement(['pendiente', 'completado']);
        $numeroTransaccion = $estado === 'completado' ? $this->generateTransactionNumber() : null;

        return [
            'id_usuario' => User::factory(),
            'id_membresia' => Membresia::factory(),
            'monto' => $this->faker->randomFloat(2, 200, 1500),
            'fecha' => $this->faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),
            'metodo_pago' => $metodoPago,
            'estado' => $estado,
            'numero_transaccion' => $numeroTransaccion,
            'notas' => $this->faker->optional(0.3)->sentence(),
        ];
    }

    /**
     * Estado para pago online completado
     */
    public function online(): static
    {
        return $this->state(fn (array $attributes) => [
            'metodo_pago' => 'online',
            'estado' => 'completado',
            'numero_transaccion' => $this->generateTransactionNumber(),
        ]);
    }

    /**
     * Estado para pago físico pendiente
     */
    public function fisicoPendiente(): static
    {
        return $this->state(fn (array $attributes) => [
            'metodo_pago' => 'fisico',
            'estado' => 'pendiente',
            'numero_transaccion' => null,
        ]);
    }

    /**
     * Estado para pago físico completado
     */
    public function fisicoCompletado(): static
    {
        return $this->state(fn (array $attributes) => [
            'metodo_pago' => 'fisico',
            'estado' => 'completado',
            'numero_transaccion' => $this->generateTransactionNumber(),
        ]);
    }

    /**
     * Estado para pago cancelado
     */
    public function cancelado(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => 'cancelado',
            'numero_transaccion' => null,
        ]);
    }

    /**
     * Generar número de transacción realista
     */
    private function generateTransactionNumber(): string
    {
        $prefijos = ['TXN', 'PAY', 'PYM', 'TRX', 'MEM'];
        $prefijo = $this->faker->randomElement($prefijos);
        $timestamp = now()->format('YmdHis');
        $random = str_pad($this->faker->numberBetween(1000, 9999), 4, '0', STR_PAD_LEFT);
        
        return $prefijo . '-' . $timestamp . '-' . $random;
    }
}
