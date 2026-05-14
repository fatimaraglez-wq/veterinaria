<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Crea el usuario administrador del sistema.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'admin',
            'email'    => 'admin@veterinaria.com',
            'password' => Hash::make('admin'),
        ]);
    }
}
