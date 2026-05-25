<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mascota;
use App\Models\Consulta;
use App\Models\Veterinario;

class ConsultaController extends Controller
{
    public function consultas(Mascota $mascota)
    {
        $mascota->load(['consultas.veterinario', 'dueno']);
        return view('modules.expedientes.consultas.index', compact('mascota'));
    }

    public function createConsulta(Mascota $mascota)
    {
        $veterinarios = Veterinario::all();
        // If the logged in user is a vet, we can pre-select them
        $currentVeterinarioId = auth()->user()->veterinario ? auth()->user()->veterinario->id : null;
        
        return view('modules.expedientes.consultas.create', compact('mascota', 'veterinarios', 'currentVeterinarioId'));
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
        
        return view('modules.expedientes.consultas.show', compact('mascota', 'consulta'));
    }

    public function diagnostico(Mascota $mascota, Consulta $consulta)
    {
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }

        return view('modules.expedientes.consultas.diagnostico', compact('mascota', 'consulta'));
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
        return view('modules.expedientes.consultas.tratamiento', compact('mascota', 'consulta'));
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
}
