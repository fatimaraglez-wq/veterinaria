@extends('layouts.app')

@section('titulo_pagina', 'Dashboard')

@section('contenido')

    {{-- Page Heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-tachometer-alt mr-2 text-primary"></i> Dashboard
        </h1>
    </div>

    {{-- Content Row - Info Cards --}}
    <div class="row">

        {{-- Card Bienvenida --}}
        <div class="col-xl-12 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Usuario Autenticado
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Bienvenido, {{ Auth::user()->name }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
