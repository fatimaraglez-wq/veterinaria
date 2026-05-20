<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mascota;
use App\Models\Consulta;

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

    public function consultas(Mascota $mascota)
    {
        $mascota->load(['consultas.veterinario', 'dueno']);
        return view('modules.expedientes.consultas', compact('mascota'));
    }

    public function showConsulta(Mascota $mascota, Consulta $consulta)
    {
        // Ensure the consulta belongs to the mascota
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }
        
        $consulta->load('veterinario');
        $mascota->load('dueno');
        
        return view('modules.expedientes.consulta_show', compact('mascota', 'consulta'));
    }
}
