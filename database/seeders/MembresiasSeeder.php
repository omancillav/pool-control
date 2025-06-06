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
        DB::table('membresias')->insert([
            [
                'id_usuario' => 1,
                'clases_adquiridas' => 20,
                'clases_disponibles' => 15,
                'clases_ocupadas' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_usuario' => 2,
                'clases_adquiridas' => 10,
                'clases_disponibles' => 8,
                'clases_ocupadas' => 2,
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'id_usuario' => 3,
                'clases_adquiridas' => 30,
                'clases_disponibles' => 25,
                'clases_ocupadas' => 5,
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(10),
            ],
        ]);
    }
}