@extends('layouts.app')

@section('titulo_pagina', 'Consultas de ' . $mascota->nombre)

@section('contenido')

    {{-- Page Heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-notes-medical mr-2 text-info"></i> Historial de Consultas: <span class="text-primary">{{ $mascota->nombre }}</span>
        </h1>
        <a href="{{ route('expedientes.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Regresar a Búsqueda
        </a>
    </div>

    <div class="row">

        {{-- Información de la Mascota --}}
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card shadow mb-4 h-100 border-left-primary">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-paw mr-2"></i>Datos del Paciente</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4 rounded-circle bg-light p-3" style="width: 12rem;" src="/startbootstrap/img/undraw_profile.svg" alt="Mascota">
                    </div>
                    <ul class="list-group list-group-flush text-gray-800">
                        <li class="list-group-item px-0 border-0"><i class="fas fa-hashtag text-gray-400 mr-2"></i> <strong>Expediente:</strong> EXP-{{ str_pad($mascota->id, 3, '0', STR_PAD_LEFT) }}</li>
                        <li class="list-group-item px-0 border-0"><i class="fas fa-dog text-gray-400 mr-2"></i> <strong>Especie:</strong> {{ $mascota->especie }}</li>
                        <li class="list-group-item px-0 border-0"><i class="fas fa-dna text-gray-400 mr-2"></i> <strong>Raza:</strong> {{ $mascota->raza ?? 'No especificada' }}</li>
                        <li class="list-group-item px-0 border-0"><i class="fas fa-birthday-cake text-gray-400 mr-2"></i> <strong>Edad:</strong> {{ $mascota->fecha_nacimiento ? $mascota->fecha_nacimiento->diffInYears(now()) . ' años' : 'Desconocida' }}</li>
                        <li class="list-group-item px-0 border-0"><i class="fas fa-user text-gray-400 mr-2"></i> <strong>Dueño:</strong> {{ $mascota->dueno->nombre_completo ?? 'Sin asignar' }}</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Lista de Consultas --}}
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card shadow mb-4 h-100 border-left-info">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white">
                    <h6 class="m-0 font-weight-bold text-info"><i class="fas fa-stethoscope mr-2"></i>Consultas Registradas</h6>
                    <a href="{{ route('expedientes.consultas.create', $mascota->id) }}" class="btn btn-sm btn-success shadow-sm">
                        <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Nueva Consulta
                    </a>
                </div>
                <div class="card-body">
                    @if($mascota->consultas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Veterinario</th>
                                        <th>Peso (kg)</th>
                                        <th>Talla (cm)</th>
                                        <th>Diagnóstico</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mascota->consultas->sortByDesc('fecha_consulta') as $consulta)
                                        <tr>
                                            <td class="align-middle whitespace-nowrap">
                                                <strong>{{ $consulta->fecha_consulta ? $consulta->fecha_consulta->format('d/m/Y') : 'N/A' }}</strong><br>
                                                <small class="text-muted">{{ $consulta->fecha_consulta ? $consulta->fecha_consulta->format('H:i') : '' }}</small>
                                            </td>
                                            <td class="align-middle">{{ $consulta->veterinario->nombre ?? 'N/A' }}</td>
                                            <td class="align-middle">{{ $consulta->peso ?? 'N/A' }}</td>
                                            <td class="align-middle">{{ $consulta->talla ?? 'N/A' }}</td>
                                            <td class="align-middle text-truncate" style="max-width: 150px;" title="{{ $consulta->diagnostico }}">{{ $consulta->diagnostico }}</td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('expedientes.consultas.show', [$mascota->id, $consulta->id]) }}" class="btn btn-info btn-sm btn-circle" title="Ver Detalles">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-medical-alt fa-4x text-gray-300 mb-3"></i>
                            <p class="lead text-gray-500 mb-0">No hay consultas registradas para este paciente.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

@endsection
