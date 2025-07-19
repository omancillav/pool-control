<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'rol' => 'Administrador',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Carlos Mendoza',
                'email' => 'carlos.mendoza@poolcontrol.com',
                'password' => Hash::make('P@ssw0rd2023!'),
                'rol' => 'Profesor',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Ana Lucía Ramírez',
                'email' => 'anaramirez@email.com',
                'password' => Hash::make('SecurePass123#'),
                'rol' => 'Cliente',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Diego Armando Sánchez',
                'email' => 'dsanchez@swimacademy.mx',
                'password' => Hash::make('Sw1mAc@d3my'),
                'rol' => 'Cliente',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}