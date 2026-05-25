<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mascota;
use App\Models\Consulta;
use App\Models\Dueno;
use App\Models\Veterinario;

class ExpedienteController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        if (!$query) {
            return response()->json([]);
        }

        // Búsqueda con Eloquent en lugar del driver básico de base de datos de Scout
        // ya que el driver 'database' de Scout no soporta buscar en relaciones (dueno_nombre no existe como columna)
        $mascotas = Mascota::with('dueno')
            ->where('id', 'like', "%{$query}%")
            ->orWhere('nombre', 'like', "%{$query}%")
            ->orWhereHas('dueno', function ($q) use ($query) {
                $q->where('nombre_completo', 'like', "%{$query}%");
            })
            ->take(5)
            ->get();

        return response()->json($mascotas);
    }

    public function create()
    {
        return view('modules.expedientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'dueno_nombre' => 'required|string|max:255',
            'dueno_telefono' => 'required|string|max:20',
            'dueno_direccion' => 'nullable|string|max:255',
            'dueno_email' => 'nullable|email|max:255',
            
            'mascota_nombre' => 'required|string|max:255',
            'mascota_especie' => 'required|string|max:255',
            'mascota_raza' => 'nullable|string|max:255',
            'mascota_fecha_nacimiento' => 'nullable|date',
            'mascota_tipo_sangre' => 'nullable|string|max:50',
            'mascota_comportamiento' => 'nullable|string|max:255',
            'mascota_es_adoptado' => 'nullable|boolean',
        ]);

        // Create or get owner by phone
        $dueno = Dueno::firstOrCreate(
            ['telefono' => $request->dueno_telefono],
            [
                'nombre_completo' => $request->dueno_nombre,
                'direccion' => $request->dueno_direccion,
                'email' => $request->dueno_email,
            ]
        );

        // Update owner data if it already existed but fields were provided
        if (!$dueno->wasRecentlyCreated) {
            $dueno->update([
                'nombre_completo' => $request->dueno_nombre,
                'direccion' => $request->dueno_direccion,
                'email' => $request->dueno_email,
            ]);
        }

        $mascota = Mascota::create([
            'dueno_id' => $dueno->id,
            'nombre' => $request->mascota_nombre,
            'especie' => $request->mascota_especie,
            'raza' => $request->mascota_raza,
            'fecha_nacimiento' => $request->mascota_fecha_nacimiento,
            'tipo_sangre' => $request->mascota_tipo_sangre ?? 'Desconocido',
            'comportamiento' => $request->mascota_comportamiento ?? 'Tranquilo',
            'es_adoptado' => $request->has('mascota_es_adoptado'),
        ]);

        return redirect()->route('expedientes.consultas', $mascota->id)->with('success', 'Paciente registrado exitosamente.');
    }


}
