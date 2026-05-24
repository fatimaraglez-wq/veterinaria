@extends('layouts.app')

@section('titulo_pagina', 'Nuevo Paciente')

@section('contenido')

    {{-- Page Heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus-circle mr-2 text-success"></i> Registrar Nuevo Paciente
        </h1>
        <a href="{{ route('expedientes.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Regresar a Búsqueda
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('expedientes.store') }}" method="POST">
        @csrf
        <div class="row">
            {{-- Datos del Dueño --}}
            <div class="col-xl-6 col-lg-6 mb-4">
                <div class="card shadow mb-4 h-100 border-left-primary">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-user mr-2"></i>Datos del Propietario</h6>
                    </div>
                    <div class="card-body text-gray-800">
                        <div class="form-group mb-3">
                            <label for="dueno_nombre" class="font-weight-bold">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="dueno_nombre" name="dueno_nombre" value="{{ old('dueno_nombre') }}" required placeholder="Ej. Juan Pérez">
                        </div>
                        <div class="form-group mb-3">
                            <label for="dueno_telefono" class="font-weight-bold">Teléfono <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="dueno_telefono" name="dueno_telefono" value="{{ old('dueno_telefono') }}" required placeholder="Ej. 555-1234">
                            <small class="form-text text-muted">Si el teléfono ya existe, se actualizarán los datos del propietario.</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="dueno_email" class="font-weight-bold">Correo Electrónico</label>
                            <input type="email" class="form-control" id="dueno_email" name="dueno_email" value="{{ old('dueno_email') }}" placeholder="Ej. juan@correo.com">
                        </div>
                        <div class="form-group mb-3">
                            <label for="dueno_direccion" class="font-weight-bold">Dirección</label>
                            <textarea class="form-control" id="dueno_direccion" name="dueno_direccion" rows="2" placeholder="Dirección completa del propietario">{{ old('dueno_direccion') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Datos de la Mascota --}}
            <div class="col-xl-6 col-lg-6 mb-4">
                <div class="card shadow mb-4 h-100 border-left-success">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white">
                        <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-paw mr-2"></i>Datos del Paciente (Mascota)</h6>
                    </div>
                    <div class="card-body text-gray-800">
                        <div class="form-group mb-3">
                            <label for="mascota_nombre" class="font-weight-bold">Nombre de la Mascota <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="mascota_nombre" name="mascota_nombre" value="{{ old('mascota_nombre') }}" required placeholder="Ej. Firulais">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="mascota_especie" class="font-weight-bold">Especie <span class="text-danger">*</span></label>
                                <select class="form-control" id="mascota_especie" name="mascota_especie" required>
                                    <option value="" disabled selected>Seleccione...</option>
                                    <option value="Perro" {{ old('mascota_especie') == 'Perro' ? 'selected' : '' }}>Perro</option>
                                    <option value="Gato" {{ old('mascota_especie') == 'Gato' ? 'selected' : '' }}>Gato</option>
                                    <option value="Ave" {{ old('mascota_especie') == 'Ave' ? 'selected' : '' }}>Ave</option>
                                    <option value="Roedor" {{ old('mascota_especie') == 'Roedor' ? 'selected' : '' }}>Roedor</option>
                                    <option value="Reptil" {{ old('mascota_especie') == 'Reptil' ? 'selected' : '' }}>Reptil</option>
                                    <option value="Otro" {{ old('mascota_especie') == 'Otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="mascota_raza" class="font-weight-bold">Raza</label>
                                <input type="text" class="form-control" id="mascota_raza" name="mascota_raza" value="{{ old('mascota_raza') }}" placeholder="Ej. Golden Retriever">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="mascota_fecha_nacimiento" class="font-weight-bold">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="mascota_fecha_nacimiento" name="mascota_fecha_nacimiento" value="{{ old('mascota_fecha_nacimiento') }}">
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="mascota_tipo_sangre" class="font-weight-bold">Tipo de Sangre</label>
                                <input type="text" class="form-control" id="mascota_tipo_sangre" name="mascota_tipo_sangre" value="{{ old('mascota_tipo_sangre') }}" placeholder="Ej. DEA 1.1">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 form-group mb-3">
                                <label for="mascota_comportamiento" class="font-weight-bold">Comportamiento</label>
                                <select class="form-control" id="mascota_comportamiento" name="mascota_comportamiento">
                                    <option value="Tranquilo" {{ old('mascota_comportamiento') == 'Tranquilo' ? 'selected' : '' }}>Tranquilo</option>
                                    <option value="Nervioso" {{ old('mascota_comportamiento') == 'Nervioso' ? 'selected' : '' }}>Nervioso</option>
                                    <option value="Agresivo" {{ old('mascota_comportamiento') == 'Agresivo' ? 'selected' : '' }}>Agresivo</option>
                                    <option value="Miedoso" {{ old('mascota_comportamiento') == 'Miedoso' ? 'selected' : '' }}>Miedoso</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group mb-3 d-flex align-items-end pb-2">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="mascota_es_adoptado" name="mascota_es_adoptado" value="1" {{ old('mascota_es_adoptado') ? 'checked' : '' }}>
                                    <label class="custom-control-label font-weight-bold" for="mascota_es_adoptado">Es adoptado</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-right mb-5">
            <a href="{{ route('expedientes.index') }}" class="btn btn-secondary shadow-sm btn-lg px-4 mr-2">
                <i class="fas fa-times mr-2"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-success shadow-sm btn-lg px-5">
                <i class="fas fa-save mr-2"></i> Registrar Paciente
            </button>
        </div>
    </form>

@endsection
