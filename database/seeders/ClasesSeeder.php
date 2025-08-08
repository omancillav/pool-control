<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Pago;
use Carbon\Carbon;

class ClasesSeeder extends Seeder
{
    public function run()
    {
        // Solo el usuario con ID 2 es Profesor según UsersSeeder
        $idProfesor = 2; // Carlos Mendoza
        $now = now();

        $clases = [
            [
                'id_profesor' => $idProfesor,
                'fecha' => Carbon::now()->addDays(1)->format('Y-m-d'),
                'nivel' => 'Principiante',
                'lugares' => 15,
                'lugares_ocupados' => 5,
                'lugares_disponibles' => 10,
                'precio' => 250.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_profesor' => $idProfesor,
                'fecha' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'nivel' => 'Aqua Aeróbicos',
                'lugares' => 20,
                'lugares_ocupados' => 12,
                'lugares_disponibles' => 8,
                'precio' => 280.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_profesor' => $idProfesor,
                'fecha' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'nivel' => 'Intermedio',
                'lugares' => 20,
                'lugares_ocupados' => 8,
                'lugares_disponibles' => 12,
                'precio' => 350.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_profesor' => $idProfesor,
                'fecha' => Carbon::now()->addDays(4)->format('Y-m-d'),
                'nivel' => 'Infantil',
                'lugares' => 12,
                'lugares_ocupados' => 6,
                'lugares_disponibles' => 6,
                'precio' => 200.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_profesor' => $idProfesor,
                'fecha' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'nivel' => 'Avanzado',
                'lugares' => 10,
                'lugares_ocupados' => 3,
                'lugares_disponibles' => 7,
                'precio' => 450.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_profesor' => $idProfesor,
                'fecha' => Carbon::now()->addDays(6)->format('Y-m-d'),
                'nivel' => 'Rehabilitación',
                'lugares' => 8,
                'lugares_ocupados' => 2,
                'lugares_disponibles' => 6,
                'precio' => 380.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_profesor' => $idProfesor,
                'fecha' => Carbon::now()->addDays(8)->format('Y-m-d'),
                'nivel' => 'Competencia',
                'lugares' => 8,
                'lugares_ocupados' => 5,
                'lugares_disponibles' => 3,
                'precio' => 550.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_profesor' => $idProfesor,
                'fecha' => Carbon::now()->addDays(10)->format('Y-m-d'),
                'nivel' => 'Nado Sincronizado',
                'lugares' => 6,
                'lugares_ocupados' => 1,
                'lugares_disponibles' => 5,
                'precio' => 500.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('clases')->insert($clases);
    }
}