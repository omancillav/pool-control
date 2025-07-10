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

        DB::table('clases')->insert([
            [
                'id_profesor' => $idProfesor,
                'fecha' => Carbon::now()->addDays(1)->format('Y-m-d'),
                'tipo' => 'Presencial',
                'lugares' => 15,
                'lugares_ocupados' => 5,
                'lugares_disponibles' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_profesor' => $idProfesor,
                'fecha' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'tipo' => 'Virtual',
                'lugares' => 20,
                'lugares_ocupados' => 8,
                'lugares_disponibles' => 12,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_profesor' => $idProfesor,
                'fecha' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'tipo' => 'Presencial',
                'lugares' => 10,
                'lugares_ocupados' => 3,
                'lugares_disponibles' => 7,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}