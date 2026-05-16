@extends('layouts.admin')

@section('title', 'Nuevo Usuario')

@section('contenido')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Crear Nuevo Usuario</h1>
        <a href="{{ route('admin.users.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a la Lista
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Datos del Usuario</h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label for="name">Nombre de Usuario (Sistema)</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar Contraseña</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="rol">Rol</label>
                            <select class="form-control" id="rol" name="rol" required onchange="toggleVeterinarioFields()">
                                <option value="" disabled selected>Seleccione un rol...</option>
                                <option value="administrador" {{ old('rol') == 'administrador' ? 'selected' : '' }}>Administrador</option>
                                <option value="veterinario" {{ old('rol') == 'veterinario' ? 'selected' : '' }}>Veterinario</option>
                            </select>
                        </div>

                        <!-- Campos extra para Veterinario -->
                        <div id="veterinario_fields" style="display: {{ old('rol') == 'veterinario' ? 'block' : 'none' }};">
                            <hr>
                            <h5 class="text-primary mb-3">Datos Médicos (Solo Veterinarios)</h5>
                            
                            <div class="form-group">
                                <label for="nombre_completo">Nombre Completo del Médico</label>
                                <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" value="{{ old('nombre_completo') }}">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="especialidad">Especialidad</label>
                                        <input type="text" class="form-control" id="especialidad" name="especialidad" value="{{ old('especialidad') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cedula_profesional">Cédula Profesional</label>
                                        <input type="text" class="form-control" id="cedula_profesional" name="cedula_profesional" value="{{ old('cedula_profesional') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mt-4">Guardar Usuario</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script src="{{ asset('js/admin/users.js') }}"></script>
@endpush
@endsection
