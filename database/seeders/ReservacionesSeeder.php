<?php

namespace Database\Seeders;

use App\Models\Reservacion;
use App\Models\Clase;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReservacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener algunos clientes y clases existentes
        $clientes = User::where('rol', 'Cliente')->get();
        $clases = Clase::where('fecha', '>=', now()->toDateString())->get();

        if ($clientes->count() > 0 && $clases->count() > 0) {
            // Crear algunas reservaciones de ejemplo
            for ($i = 0; $i < 10; $i++) {
                $cliente = $clientes->random();
                $clase = $clases->random();

                // Verificar que no exista ya una reservación para este cliente y clase
                if (!Reservacion::where('id_usuario', $cliente->id)
                    ->where('id_clase', $clase->id)
                    ->exists()) {
                    
                    Reservacion::create([
                        'id_usuario' => $cliente->id,
                        'id_clase' => $clase->id,
                        'notas' => fake()->optional(0.3)->sentence()
                    ]);
                }
            }
        }
    }
}
