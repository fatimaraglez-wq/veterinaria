<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Veterinario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Administrador
        User::create([
            'name'     => 'Administrador',
            'email'    => 'admin@veterinaria.com',
            'password' => Hash::make('admin'),
            'rol'      => 'administrador',
        ]);

        // 2. Veterinario
        $vet1 = User::create([
            'name'     => 'Veterinario',
            'email'    => 'veterinario@gmail.com',
            'password' => Hash::make('password'),
            'rol'      => 'veterinario',
        ]);
        Veterinario::create([
            'usuario_id' => $vet1->id,
            'nombre_completo' => 'Dr. Veterinario',
            'especialidad' => 'General',
            'cedula_profesional' => '12345678',
        ]);

        // 3. Balam
        $vet2 = User::create([
            'name'     => 'Balam',
            'email'    => 'balam@gmail.com',
            'password' => Hash::make('password'),
            'rol'      => 'veterinario',
        ]);
        Veterinario::create([
            'usuario_id' => $vet2->id,
            'nombre_completo' => 'Dr. Balam',
            'especialidad' => 'Cirugía',
            'cedula_profesional' => '87654321',
        ]);

        // 4. Tia Paola
        User::create([
            'name'     => 'Tia Paola',
            'email'    => 'paola@gmail.com',
            'password' => Hash::make('password'),
            'rol'      => 'administrador',
        ]);
    }
}
