@extends('layouts.app')

@section('titulo_pagina', 'Nueva Consulta - ' . $mascota->nombre)

@section('contenido')

    {{-- Page Heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-stethoscope mr-2 text-success"></i> Nueva Consulta: <span class="text-primary">{{ $mascota->nombre }}</span>
        </h1>
        <a href="{{ route('expedientes.consultas', $mascota->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Regresar a Historial
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

    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="card shadow mb-4 border-left-success">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white">
                    <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-file-medical mr-2"></i>Datos de la Consulta</h6>
                </div>
                <div class="card-body text-gray-800 p-4">
                    
                    <form action="{{ route('expedientes.consultas.store', $mascota->id) }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 form-group mb-4">
                                <label for="fecha_consulta" class="font-weight-bold">Fecha y Hora <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control form-control-lg" id="fecha_consulta" name="fecha_consulta" value="{{ old('fecha_consulta', now()->format('Y-m-d\TH:i')) }}" required>
                            </div>
                            
                            <div class="col-md-6 form-group mb-4">
                                <label for="veterinario_id" class="font-weight-bold">Veterinario Atendió <span class="text-danger">*</span></label>
                                <select class="form-control form-control-lg" id="veterinario_id" name="veterinario_id" required>
                                    <option value="" disabled selected>Seleccione un veterinario...</option>
                                    @foreach($veterinarios as $vet)
                                        <option value="{{ $vet->id }}" {{ (old('veterinario_id', $currentVeterinarioId) == $vet->id) ? 'selected' : '' }}>
                                            Dr/Dra. {{ $vet->nombre_completo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-4">
                                <label for="peso" class="font-weight-bold">Peso (kg)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" class="form-control form-control-lg" id="peso" name="peso" value="{{ old('peso') }}" placeholder="Ej. 12.5">
                                    <div class="input-group-append">
                                        <span class="input-group-text">kg</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 form-group mb-4">
                                <label for="talla" class="font-weight-bold">Talla (cm)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" class="form-control form-control-lg" id="talla" name="talla" value="{{ old('talla') }}" placeholder="Ej. 45.0">
                                    <div class="input-group-append">
                                        <span class="input-group-text">cm</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="mt-2 mb-4">

                        <div class="form-group mb-4">
                            <label for="diagnostico" class="font-weight-bold">Motivo de la consulta / Diagnóstico inicial (Opcional)</label>
                            <textarea class="form-control" id="diagnostico" name="diagnostico" rows="4" placeholder="Describa brevemente el motivo de la visita o el diagnóstico preliminar...">{{ old('diagnostico') }}</textarea>
                            <small class="form-text text-muted">Podrá detallar el diagnóstico y el tratamiento con formato avanzado más adelante desde el expediente de la consulta.</small>
                        </div>

                        <div class="text-right mt-5">
                            <a href="{{ route('expedientes.consultas', $mascota->id) }}" class="btn btn-secondary shadow-sm btn-lg px-4 mr-2">
                                <i class="fas fa-times mr-2"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-success shadow-sm btn-lg px-5">
                                <i class="fas fa-save mr-2"></i> Registrar Consulta
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
