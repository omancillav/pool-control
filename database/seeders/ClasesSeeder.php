<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClasesSeeder extends Seeder
{
    public function run()
    {
        $profesoresIds = [1, 2, 3, 4]; // IDs de usuarios que ya tienes

        DB::table('clases')->insert([
            [
                'fecha' => Carbon::now()->addDays(1)->format('Y-m-d'),
                'id_profesor' => $profesoresIds[0], // Usuario con ID 1
                'tipo' => 'Presencial',
                'lugares' => 20,
                'lugares_ocupados' => 5,
                'lugares_disponibles' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'id_profesor' => $profesoresIds[1], // Usuario con ID 2
                'tipo' => 'Virtual',
                'lugares' => 30,
                'lugares_ocupados' => 10,
                'lugares_disponibles' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'id_profesor' => $profesoresIds[2], // Usuario con ID 3
                'tipo' => 'Presencial',
                'lugares' => 15,
                'lugares_ocupados' => 7,
                'lugares_disponibles' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fecha' => Carbon::now()->addDays(7)->format('Y-m-d'),
                'id_profesor' => $profesoresIds[3], // Usuario con ID 4
                'tipo' => 'Virtual',
                'lugares' => 25,
                'lugares_ocupados' => 12,
                'lugares_disponibles' => 13,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}