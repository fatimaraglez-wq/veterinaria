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

    public function consultas(Mascota $mascota)
    {
        $mascota->load(['consultas.veterinario', 'dueno']);
        return view('modules.expedientes.consultas', compact('mascota'));
    }

    public function createConsulta(Mascota $mascota)
    {
        $veterinarios = Veterinario::all();
        // If the logged in user is a vet, we can pre-select them
        $currentVeterinarioId = auth()->user()->veterinario ? auth()->user()->veterinario->id : null;
        
        return view('modules.expedientes.consulta_create', compact('mascota', 'veterinarios', 'currentVeterinarioId'));
    }

    public function storeConsulta(Request $request, Mascota $mascota)
    {
        $request->validate([
            'veterinario_id' => 'required|exists:veterinarios,id',
            'fecha_consulta' => 'required|date',
            'peso' => 'nullable|numeric|min:0',
            'talla' => 'nullable|numeric|min:0',
            'diagnostico' => 'nullable|string',
            'tratamiento' => 'nullable|string',
        ]);

        $consulta = Consulta::create([
            'mascota_id' => $mascota->id,
            'veterinario_id' => $request->veterinario_id,
            'fecha_consulta' => $request->fecha_consulta,
            'peso' => $request->peso,
            'talla' => $request->talla,
            'diagnostico' => $request->diagnostico,
            'tratamiento' => $request->tratamiento,
        ]);

        return redirect()->route('expedientes.consultas.show', [$mascota->id, $consulta->id])
            ->with('success', 'Consulta registrada exitosamente.');
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

    public function diagnostico(Mascota $mascota, Consulta $consulta)
    {
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }

        return view('modules.expedientes.diagnostico', compact('mascota', 'consulta'));
    }

    public function updateDiagnostico(Request $request, Mascota $mascota, Consulta $consulta)
    {
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }

        $request->validate([
            'diagnostico' => 'nullable|string',
        ]);

        // Verificar si es información nueva o actualización
        $esNuevo = empty($consulta->diagnostico);

        $consulta->diagnostico = $request->input('diagnostico');
        $consulta->save();

        // Definir el mensaje según la acción
        $mensaje = $esNuevo ? 'Se guardó la nueva información.' : 'Se actualizó con éxito.';

        return redirect()->route('expedientes.consultas.diagnostico', [$mascota->id, $consulta->id])
            ->with('success', $mensaje);
    }

    public function tratamiento(Mascota $mascota, Consulta $consulta)
    {
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }
        return view('modules.expedientes.tratamiento', compact('mascota', 'consulta'));
    }

    public function updateTratamiento(Request $request, Mascota $mascota, Consulta $consulta)
    {
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }
        $request->validate(['tratamiento' => 'nullable|string']);
        $consulta->tratamiento = $request->input('tratamiento');
        $consulta->save();
        return redirect()->route('expedientes.consultas.tratamiento', [$mascota->id, $consulta->id])
            ->with('success', 'Tratamiento guardado con éxito.');
    }

    public function alergias(Mascota $mascota)
    {
        return view('modules.expedientes.alergias', compact('mascota'));
    }

    public function updateAlergias(Request $request, Mascota $mascota)
    {
        $request->validate(['alergias' => 'nullable|string']);
        $mascota->alergias = $request->input('alergias');
        $mascota->save();
        return redirect()->route('expedientes.mascotas.alergias', $mascota->id)
            ->with('success', 'Alergias actualizadas con éxito.');
    }

    public function lesiones(Mascota $mascota)
    {
        return view('modules.expedientes.lesiones', compact('mascota'));
    }

    public function updateLesiones(Request $request, Mascota $mascota)
    {
        $request->validate(['lesiones' => 'nullable|string']);
        $mascota->lesiones = $request->input('lesiones');
        $mascota->save();
        return redirect()->route('expedientes.mascotas.lesiones', $mascota->id)
            ->with('success', 'Lesiones actualizadas con éxito.');
    }

    public function patologicos(Mascota $mascota)
    {
        return view('modules.expedientes.patologicos', compact('mascota'));
    }

    public function updatePatologicos(Request $request, Mascota $mascota)
    {
        $request->validate(['patologicos' => 'nullable|string']);
        $mascota->patologicos = $request->input('patologicos');
        $mascota->save();
        return redirect()->route('expedientes.mascotas.patologicos', $mascota->id)
            ->with('success', 'Antecedentes patológicos actualizados con éxito.');
    }

    public function nutricion(Mascota $mascota)
    {
        return view('modules.expedientes.nutricion', compact('mascota'));
    }

    public function updateNutricion(Request $request, Mascota $mascota)
    {
        $request->validate(['historial_alimentacion' => 'nullable|string']);
        $mascota->historial_alimentacion = $request->input('historial_alimentacion');
        $mascota->save();
        return redirect()->route('expedientes.mascotas.nutricion', $mascota->id)
            ->with('success', 'Historial de alimentación actualizado con éxito.');
    }
}
