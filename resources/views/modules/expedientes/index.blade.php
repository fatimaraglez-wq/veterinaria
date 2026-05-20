@extends('layouts.app')

@section('titulo_pagina', 'Expedientes')

{{-- Ocultar el sidebar en esta vista --}}
@section('hide_sidebar', true)

@push('styles')
<style>
    /* Estilos para los resultados de la búsqueda */
    .search-results-container {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 1000;
        display: none;
        max-height: 300px;
        overflow-y: auto;
    }
    .search-result-item {
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .search-result-item:hover {
        background-color: #f8f9fa;
    }
</style>
@endpush

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
                    <div class="form-group mb-5 text-center position-relative">
                        <label for="buscadorExpedientes" class="text-gray-600 mb-3" style="font-size: 1.1rem;">Ingrese el nombre, propietario o número de expediente de la mascota:</label>
                        <div class="input-group input-group-lg shadow-sm">
                            <input type="text" autocomplete="off" class="form-control bg-light border-0" id="buscadorExpedientes" placeholder="Ej. Firulais, Juan Pérez, EXP-001..." aria-label="Search">
                        </div>
                        
                        {{-- Contenedor de Resultados --}}
                        <div id="search-results" class="list-group shadow search-results-container text-left mt-1 rounded"></div>
                    </div>

                    <hr class="mb-4">

                    {{-- Botones de Acción --}}
                    <div class="d-flex justify-content-center flex-wrap mt-4">
                        <a href="#" id="btnVerConsultas" class="btn btn-info btn-icon-split btn-lg mx-2 mb-3 shadow-sm disabled" aria-disabled="true">
                            <span class="icon text-white-50">
                                <i class="fas fa-stethoscope"></i>
                            </span>
                            <span class="text">Ver Consultas</span>
                        </a>

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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputBuscador = document.getElementById('buscadorExpedientes');
        const resultadosContainer = document.getElementById('search-results');
        let debounceTimer;

        // Función para realizar la búsqueda
        const realizarBusqueda = async (query) => {
            if (query.length < 2) {
                resultadosContainer.style.display = 'none';
                resultadosContainer.innerHTML = '';
                return;
            }

            try {
                // Hacer la petición GET a la API
                const response = await fetch(`{{ route('expedientes.search') }}?q=${encodeURIComponent(query)}`);
                const mascotas = await response.json();

                resultadosContainer.innerHTML = '';

                if (mascotas.length === 0) {
                    resultadosContainer.innerHTML = `
                        <div class="list-group-item text-muted">No se encontraron resultados para "${query}"</div>
                    `;
                    resultadosContainer.style.display = 'block';
                    return;
                }

                // Renderizar los resultados
                mascotas.forEach(mascota => {
                    const nombreDueno = mascota.dueno ? mascota.dueno.nombre_completo : 'Sin dueño asignado';
                    
                    const a = document.createElement('a');
                    a.href = '#'; // Cambiar esto por la ruta real al expediente cuando exista
                    a.className = 'list-group-item list-group-item-action search-result-item flex-column align-items-start';
                    
                    a.innerHTML = `
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1 text-primary font-weight-bold">
                                <i class="fas fa-paw mr-1"></i> ${mascota.nombre} 
                                <span class="badge badge-secondary ml-2">EXP-${mascota.id.toString().padStart(3, '0')}</span>
                            </h5>
                            <small class="text-muted">${mascota.especie}</small>
                        </div>
                        <p class="mb-1 text-gray-800"><i class="fas fa-user mr-1 text-gray-400"></i> Dueño: ${nombreDueno}</p>
                    `;
                    
                    // Al hacer click, que rellene el input (opcional) o navegue
                    a.addEventListener('click', function(e) {
                        e.preventDefault();
                        inputBuscador.value = mascota.nombre;
                        resultadosContainer.style.display = 'none';
                        
                        // Habilitar y actualizar el botón "Ver Consultas"
                        const btnVerConsultas = document.getElementById('btnVerConsultas');
                        btnVerConsultas.href = `/expedientes/${mascota.id}/consultas`;
                        btnVerConsultas.classList.remove('disabled');
                        btnVerConsultas.removeAttribute('aria-disabled');
                    });

                    resultadosContainer.appendChild(a);
                });

                resultadosContainer.style.display = 'block';

            } catch (error) {
                console.error("Error al buscar: ", error);
            }
        };

        // Evento 'input' con debounce
        inputBuscador.addEventListener('input', function (e) {
            const query = e.target.value.trim();
            
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                realizarBusqueda(query);
            }, 300); // 300ms delay
        });

        // Ocultar resultados si se hace click fuera
        document.addEventListener('click', function(e) {
            if (!inputBuscador.contains(e.target) && !resultadosContainer.contains(e.target)) {
                resultadosContainer.style.display = 'none';
            }
        });
        
        // Mostrar de nuevo si se hace click en el input
        inputBuscador.addEventListener('focus', function() {
            if (this.value.trim().length >= 2 && resultadosContainer.innerHTML.trim() !== '') {
                resultadosContainer.style.display = 'block';
            }
        });
    });
</script>
@endpush
