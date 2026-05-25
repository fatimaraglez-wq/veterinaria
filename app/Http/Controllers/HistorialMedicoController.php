<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mascota;

class HistorialMedicoController extends Controller
{
    public function alergias(Mascota $mascota)
    {
        return view('modules.expedientes.historial.alergias', compact('mascota'));
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
        return view('modules.expedientes.historial.lesiones', compact('mascota'));
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
        return view('modules.expedientes.historial.patologicos', compact('mascota'));
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
        return view('modules.expedientes.historial.nutricion', compact('mascota'));
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
