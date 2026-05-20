@extends('layouts.app')

@section('titulo_pagina', 'Detalles de Consulta')

@section('contenido')

    {{-- Page Heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-file-medical mr-2 text-info"></i> Detalles de Consulta: <span class="text-primary">{{ $mascota->nombre }}</span>
        </h1>
        <a href="{{ route('expedientes.consultas', $mascota->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Regresar a Consultas
        </a>
    </div>

    <div class="row">

        {{-- Detalles de la Consulta --}}
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card shadow mb-4 h-100 border-left-info">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white">
                    <h6 class="m-0 font-weight-bold text-info"><i class="fas fa-stethoscope mr-2"></i>Información Clínica</h6>
                    <span class="badge badge-primary px-3 py-2" style="font-size: 0.9rem;">
                        {{ $consulta->fecha_consulta ? $consulta->fecha_consulta->format('d \d\e M, Y h:i A') : 'Fecha no especificada' }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <h6 class="font-weight-bold text-gray-800 mb-1">Veterinario Tratante</h6>
                            <p class="text-muted"><i class="fas fa-user-md mr-2"></i>{{ $consulta->veterinario->nombre ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <h6 class="font-weight-bold text-gray-800 mb-1">Peso</h6>
                            <p class="text-muted"><i class="fas fa-weight mr-2"></i>{{ $consulta->peso ? $consulta->peso . ' kg' : 'N/A' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <h6 class="font-weight-bold text-gray-800 mb-1">Talla</h6>
                            <p class="text-muted"><i class="fas fa-ruler-vertical mr-2"></i>{{ $consulta->talla ? $consulta->talla . ' cm' : 'N/A' }}</p>
                        </div>
                    </div>

                    <hr>


                </div>
            </div>
        </div>

        {{-- Antecedentes de la Mascota --}}
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card shadow mb-4 border-left-success h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white">
                    <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-history mr-2"></i>Datos del paciente</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h5 class="font-weight-bold text-primary mb-1">{{ $mascota->nombre }}</h5>
                        <p class="text-muted small mb-0">{{ $mascota->especie }} | {{ $mascota->raza ?? 'Raza desconocida' }}</p>
                    </div>
                    
                    <ul class="list-group list-group-flush text-gray-800">
                        <li class="list-group-item px-0 border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-tint text-danger mr-2"></i><strong>Tipo de Sangre:</strong></span>
                                <span class="badge badge-light px-2 py-1">{{ $mascota->tipo_sangre ?? 'No especificado' }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-brain text-info mr-2"></i><strong>Comportamiento:</strong></span>
                                <span class="text-muted">{{ $mascota->comportamiento ?? 'Normal' }}</span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-home text-success mr-2"></i><strong>Adoptado:</strong></span>
                                <span>
                                    @if($mascota->es_adoptado)
                                        <i class="fas fa-check text-success"></i> Sí
                                    @else
                                        <i class="fas fa-times text-danger"></i> No
                                    @endif
                                </span>
                            </div>
                        </li>
                    </ul>

                    <hr>
                    
                    <div class="mt-3">
                        <h6 class="font-weight-bold text-gray-700 mb-2"><i class="fas fa-notes-medical text-secondary mr-2"></i>Otras Notas</h6>
                        <p class="text-muted small">No hay más antecedentes médicos registrados para este paciente por el momento.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
