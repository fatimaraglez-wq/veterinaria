@extends('layouts.app')

@section('titulo_pagina', 'Expedientes')

{{-- Ocultar el sidebar en esta vista --}}
@section('hide_sidebar', true)

@section('contenido')

    {{-- Page Heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-folder-open mr-2 text-primary"></i> Expedientes
        </h1>
        <a href="{{ Auth::user()->rol === 'administrador' ? route('admin.home') : route('home') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Regresar al Dashboard
        </a>
    </div>

    {{-- Content Row --}}
    <div class="row justify-content-center mt-5">

        <div class="col-xl-8 col-lg-10 mb-4">
            <div class="card shadow-lg mb-4 border-0 rounded-lg">
                <div class="card-header py-4 bg-primary text-center">
                    <h5 class="m-0 font-weight-bold text-white"><i class="fas fa-search mr-2"></i>Búsqueda de Expedientes</h5>
                </div>
                <div class="card-body p-5">
                    
                    {{-- Buscador --}}
                    <div class="form-group mb-5 text-center">
                        <label for="buscadorExpedientes" class="text-gray-600 mb-3" style="font-size: 1.1rem;">Ingrese el nombre, propietario o número de expediente de la mascota:</label>
                        <div class="input-group input-group-lg shadow-sm">
                            <input type="text" class="form-control bg-light border-0" id="buscadorExpedientes" placeholder="Ej. Firulais, Juan Pérez, EXP-001..." aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary px-4" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <hr class="mb-4">

                    {{-- Botones de Acción --}}
                    <div class="d-flex justify-content-center flex-wrap mt-4">
                        <button class="btn btn-info btn-icon-split btn-lg mx-2 mb-3 shadow-sm">
                            <span class="icon text-white-50">
                                <i class="fas fa-stethoscope"></i>
                            </span>
                            <span class="text">Ver Consultas</span>
                        </button>

                        <button class="btn btn-success btn-icon-split btn-lg mx-2 mb-3 shadow-sm">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Nuevo Paciente</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection
