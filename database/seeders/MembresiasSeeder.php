<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


class MembresiasSeeder extends Seeder
{
    public function run()
    {
        // Aquí insertamos datos de prueba a la tabla membresias
        // Solo clientes (IDs 3 y 4) deben tener membresías
        DB::table('membresias')->insert([
            [
                'id_usuario' => 3, // Ana Lucía Ramírez
                'clases_adquiridas' => 20,
                'clases_disponibles' => 15,
                'clases_ocupadas' => 5,
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(10),
            ],
            [
                'id_usuario' => 4, // Diego Armando Sánchez
                'clases_adquiridas' => 30,
                'clases_disponibles' => 25,
                'clases_ocupadas' => 5,
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}