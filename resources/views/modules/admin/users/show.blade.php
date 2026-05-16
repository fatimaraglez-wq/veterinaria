@extends('layouts.admin')

@section('title', 'Confirmar Eliminación')

@section('contenido')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Eliminar Usuario</h1>
        <a href="{{ route('admin.users.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a la Lista
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow mb-4 border-left-danger">
                <div class="card-header py-3 bg-danger">
                    <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-exclamation-triangle"></i> Zona de Peligro: Confirmar Eliminación</h6>
                </div>
                <div class="card-body">
                    
                    <p class="text-danger font-weight-bold text-center mb-4" style="font-size: 1.1rem;">
                        Estás a punto de eliminar a este usuario del sistema. Esta acción no se puede deshacer.
                    </p>

                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <strong>Resumen del Usuario a Eliminar</strong>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>ID:</strong> {{ $user->id }}</li>
                            <li class="list-group-item"><strong>Nombre:</strong> {{ $user->name }}</li>
                            <li class="list-group-item"><strong>Correo Electrónico:</strong> {{ $user->email }}</li>
                            <li class="list-group-item">
                                <strong>Rol:</strong> 
                                @if($user->rol === 'administrador')
                                    <span class="badge badge-primary">Administrador</span>
                                @else
                                    <span class="badge badge-success">Veterinario</span>
                                @endif
                            </li>
                            
                            @if($user->rol === 'veterinario' && $user->veterinario)
                            <li class="list-group-item list-group-item-success">
                                <h6 class="font-weight-bold mt-2"><i class="fas fa-user-md"></i> Datos Médicos que también serán eliminados:</h6>
                                <ul>
                                    <li><strong>Nombre Completo:</strong> {{ $user->veterinario->nombre_completo }}</li>
                                    <li><strong>Especialidad:</strong> {{ $user->veterinario->especialidad }}</li>
                                    <li><strong>Cédula:</strong> {{ $user->veterinario->cedula_profesional }}</li>
                                </ul>
                            </li>
                            @endif
                        </ul>
                    </div>

                    @if($hasDependencies)
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-ban fa-2x mb-2 text-warning"></i><br>
                            <strong>¡Operación Bloqueada!</strong><br>
                            No puedes eliminar a este usuario porque existen datos y registros en el sistema vinculados a él.
                        </div>
                        <div class="text-center">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Regresar sin hacer nada</a>
                        </div>
                    @else
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="text-center">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i> Sí, estoy seguro de eliminarlo
                            </button>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
