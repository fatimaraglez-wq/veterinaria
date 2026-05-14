@extends('layouts.auth')

@section('titulo_pagina', 'Iniciar Sesión')

@section('contenido')
<div class="container">

    {{-- Outer Row --}}
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">

                    {{-- Nested Row within Card Body --}}
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">

                                <div class="text-center">
                                    <i class="fas fa-paw fa-3x text-primary mb-3"></i>
                                    <h1 class="h4 text-gray-900 mb-4">Sistema Veterinaria</h1>
                                </div>

                                {{-- Mensajes de error --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form class="user" action="{{ route('logear') }}" method="POST">
                                    @csrf

                                    <div class="form-group">
                                        <input
                                            type="email"
                                            class="form-control form-control-user @error('email') is-invalid @enderror"
                                            id="email"
                                            name="email"
                                            value="{{ old('email') }}"
                                            placeholder="Correo electrónico..."
                                            required
                                            autofocus>
                                    </div>

                                    <div class="form-group">
                                        <input
                                            type="password"
                                            class="form-control form-control-user @error('password') is-invalid @enderror"
                                            id="password"
                                            name="password"
                                            placeholder="Contraseña"
                                            required>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        <i class="fas fa-sign-in-alt mr-1"></i> Iniciar Sesión
                                    </button>

                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>
@endsection
