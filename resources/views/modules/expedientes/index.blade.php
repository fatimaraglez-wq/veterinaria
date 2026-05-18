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
    <div class="row">

        <div class="col-xl-12 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Gestión de Expedientes
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Próximamente se implementará el módulo de expedientes aquí.
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-medical fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
