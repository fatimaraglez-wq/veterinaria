<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mascota;

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
}
