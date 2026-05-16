<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Veterinario;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(5);
        return view('modules.admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('modules.admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
        ]);

        if ($request->rol === 'veterinario') {
            Veterinario::create([
                'usuario_id' => $user->id,
                'nombre_completo' => $request->nombre_completo,
                'especialidad' => $request->especialidad,
                'cedula_profesional' => $request->cedula_profesional,
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $user)
    {
        // Cargar relación de veterinario si existe
        $user->load('veterinario');
        return view('modules.admin.users.edit', compact('user'));
    }

    public function show(User $user)
    {
        $user->load('veterinario');
        $hasDependencies = $user->hasRestrictedDependencies();
        
        return view('modules.admin.users.show', compact('user', 'hasDependencies'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->rol = $request->rol;

        // Actualizar contraseña solo si se ingresó una nueva
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Manejar datos del veterinario
        if ($request->rol === 'veterinario') {
            Veterinario::updateOrCreate(
                ['usuario_id' => $user->id],
                [
                    'nombre_completo' => $request->nombre_completo,
                    'especialidad' => $request->especialidad,
                    'cedula_profesional' => $request->cedula_profesional,
                ]
            );
        } else {
            // Si cambió de Veterinario a Administrador, eliminamos el registro médico
            if ($user->veterinario) {
                $user->veterinario()->delete();
            }
        }

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        if ($user->hasRestrictedDependencies()) {
            return redirect()->route('admin.users.index')->withErrors(['error' => 'No puedes eliminar este usuario porque contiene datos vinculados.']);
        }

        try {
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.users.index')->withErrors(['error' => 'No se puede eliminar el usuario porque contiene datos vinculados en el sistema.']);
        }
    }
}
