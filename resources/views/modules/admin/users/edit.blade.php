@extends('layouts.admin')

@section('title', 'Editar Usuario')

@section('contenido')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Editar Usuario</h1>
        <a href="{{ route('admin.users.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a la Lista
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-user-edit"></i> Información del Usuario</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Nombre -->
                            <div class="col-md-6 mb-3">
                                <label for="name">Nombre de Usuario <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Correo -->
                            <div class="col-md-6 mb-3">
                                <label for="email">Correo Electrónico <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Contraseña -->
                            <div class="col-md-6 mb-3">
                                <label for="password">Nueva Contraseña</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Deja en blanco para no cambiar">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Confirmar Contraseña -->
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Deja en blanco para no cambiar">
                            </div>

                            <!-- Rol -->
                            <div class="col-md-6 mb-3">
                                <label for="rol">Rol del Sistema <span class="text-danger">*</span></label>
                                <select class="form-control @error('rol') is-invalid @enderror" id="rol" name="rol" onchange="toggleVeterinarioFields()" required>
                                    <option value="" disabled>Seleccione un rol...</option>
                                    <option value="administrador" {{ old('rol', $user->rol) == 'administrador' ? 'selected' : '' }}>Administrador</option>
                                    <option value="veterinario" {{ old('rol', $user->rol) == 'veterinario' ? 'selected' : '' }}>Veterinario</option>
                                </select>
                                @error('rol') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Campos extra para Veterinario -->
                        <div id="veterinario_fields" style="display: {{ old('rol', $user->rol) == 'veterinario' ? 'block' : 'none' }};">
                            <hr>
                            <h5 class="text-primary mb-3">Datos Médicos (Solo Veterinarios)</h5>
                            
                            <div class="form-group">
                                <label for="nombre_completo">Nombre Completo del Médico</label>
                                <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" value="{{ old('nombre_completo', $user->veterinario->nombre_completo ?? '') }}">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="especialidad">Especialidad</label>
                                        <input type="text" class="form-control" id="especialidad" name="especialidad" value="{{ old('especialidad', $user->veterinario->especialidad ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cedula_profesional">Cédula Profesional</label>
                                        <input type="text" class="form-control" id="cedula_profesional" name="cedula_profesional" value="{{ old('cedula_profesional', $user->veterinario->cedula_profesional ?? '') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script src="{{ asset('js/admin/users.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            toggleVeterinarioFields();
        });
    </script>
@endpush
@endsection
