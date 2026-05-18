<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Dueno;
use App\Models\Mascota;
use App\Models\Consulta;
use App\Models\Veterinario;
use App\Models\User;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asegurarnos de tener un veterinario para asociarle las consultas
        $veterinario = Veterinario::first();
        
        if (!$veterinario) {
            $user = User::factory()->create([
                'name' => 'Dr. Demo',
                'email' => 'dr.demo@veterinaria.com',
                'rol' => 'veterinario',
            ]);
            
            $veterinario = Veterinario::create([
                'usuario_id' => $user->id,
                'nombre_completo' => 'Dr. Demo',
                'especialidad' => 'Medicina General',
                'cedula_profesional' => '12345678',
            ]);
        }

        // Crear un dueño
        $dueno = Dueno::create([
            'nombre_completo' => 'Carlos López',
            'telefono' => '555-1234',
            'direccion' => 'Calle Falsa 123, Ciudad',
            'email' => 'carlos.lopez@example.com',
        ]);

        // Crear una mascota
        $mascota = Mascota::create([
            'dueno_id' => $dueno->id,
            'nombre' => 'Firulais',
            'especie' => 'Perro',
            'raza' => 'Golden Retriever',
            'fecha_nacimiento' => Carbon::now()->subYears(3)->format('Y-m-d'),
            'tipo_sangre' => 'DEA 1.1',
            'comportamiento' => 'Tranquilo y juguetón',
            'es_adoptado' => true,
        ]);

        // Crear dos consultas
        Consulta::create([
            'mascota_id' => $mascota->id,
            'veterinario_id' => $veterinario->id,
            'fecha_consulta' => Carbon::now()->subDays(15),
            'peso' => 25.50,
            'talla' => 60.00,
            'diagnostico' => 'Revisión general. Presenta buena salud, pero le falta la vacuna antirrábica.',
            'tratamiento' => 'Se aplicó vacuna antirrábica. Cita de seguimiento en un año.',
        ]);

        Consulta::create([
            'mascota_id' => $mascota->id,
            'veterinario_id' => $veterinario->id,
            'fecha_consulta' => Carbon::now(),
            'peso' => 26.00,
            'talla' => 60.50,
            'diagnostico' => 'Infección leve en oído derecho (Otitis).',
            'tratamiento' => 'Limpieza de oídos con solución especial. Aplicar gotas antibióticas 2 veces al día por 7 días.',
        ]);
    }
}
