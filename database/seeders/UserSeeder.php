<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Crea los usuarios de prueba del sistema.
     */
    public function run(): void
    {
        // Usuario Administrador
        User::create([
            'name'     => 'admin',
            'email'    => 'admin@veterinaria.com',
            'password' => Hash::make('admin'),
            'rol'      => 'administrador',
        ]);

        // Usuario Veterinario de prueba
        User::create([
            'name'     => 'veterinario',
            'email'    => 'vet@veterinaria.com',
            'password' => Hash::make('veterinario'),
            'rol'      => 'veterinario',
        ]);
    }
}
