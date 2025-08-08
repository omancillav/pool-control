<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
                'lugares_ocupados' => 3,
                'lugares_disponibles' => 12,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_profesor' => $idProfesor,
                'fecha' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'nivel' => 'Intermedio',
                'lugares' => 12,
                'lugares_ocupados' => 5,
                'lugares_disponibles' => 7,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_profesor' => $idProfesor,
                'fecha' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'nivel' => 'Avanzado',
                'lugares' => 10,
                'lugares_ocupados' => 2,
                'lugares_disponibles' => 8,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_profesor' => $idProfesor,
                'fecha' => Carbon::now()->addDays(4)->format('Y-m-d'),
                'nivel' => 'Infantil',
                'lugares' => 8,
                'lugares_ocupados' => 1,
                'lugares_disponibles' => 7,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_profesor' => $idProfesor,
                'fecha' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'nivel' => 'Terapéutico',
                'lugares' => 6,
                'lugares_ocupados' => 0,
                'lugares_disponibles' => 6,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_profesor' => $idProfesor,
                'fecha' => Carbon::now()->addDays(7)->format('Y-m-d'),
                'nivel' => 'Competencia',
                'lugares' => 8,
                'lugares_ocupados' => 4,
                'lugares_disponibles' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('clases')->insert($clases);
    }
}