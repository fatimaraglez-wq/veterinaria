@extends('layouts.admin')

@section('titulo_pagina', 'Dashboard Admin')

@push('styles')
<style>
    .stat-card-icon { font-size: 2rem; opacity: 0.3; }
    .border-left-admin { border-left: 0.25rem solid #e74a3b !important; }
</style>
@endpush

@section('contenido')

    {{-- Page Heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-shield-alt mr-2 text-danger"></i> Panel de Administración
        </h1>
        <span class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
            <i class="fas fa-user-shield fa-sm text-white-50 mr-1"></i>
            Bienvenido, {{ Auth::user()->name }}
        </span>
    </div>

    {{-- Content Row - Tarjetas de Estadísticas --}}
    <div class="row">

        {{-- Card - Usuarios Totales --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Usuarios Registrados
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300 stat-card-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card - Veterinarios --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Veterinarios Activos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-md fa-2x text-gray-300 stat-card-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card - Consultas del Mes --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Consultas del Mes
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">0</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: 0%" aria-valuenow="0" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300 stat-card-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card - Pendientes --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pendientes de Revisión
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300 stat-card-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- End of Content Row --}}

    {{-- Content Row - Gráficas --}}
    <div class="row">

        {{-- Gráfica de Área --}}
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-chart-area mr-1"></i> Actividad Mensual
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="adminAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gráfica de Donut --}}
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-chart-pie mr-1"></i> Distribución por Rol
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="adminPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Veterinarios
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-danger"></i> Administradores
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- End of Row Gráficas --}}

    {{-- Content Row - Info adicional --}}
    <div class="row">

        {{-- Card Acceso Rápido --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-bolt mr-1"></i> Acceso Rápido
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <a href="#" class="btn btn-primary btn-block shadow-sm">
                                <i class="fas fa-users mr-1"></i> Gestionar Usuarios
                            </a>
                        </div>
                        <div class="col-6 mb-3">
                            <a href="#" class="btn btn-success btn-block shadow-sm">
                                <i class="fas fa-chart-bar mr-1"></i> Ver Reportes
                            </a>
                        </div>
                        <div class="col-6 mb-3">
                            <a href="#" class="btn btn-info btn-block shadow-sm">
                                <i class="fas fa-clipboard-list mr-1"></i> Consultas
                            </a>
                        </div>
                        <div class="col-6 mb-3">
                            <a href="#" class="btn btn-secondary btn-block shadow-sm">
                                <i class="fas fa-cog mr-1"></i> Configuración
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Info del Sistema --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-info-circle mr-1"></i> Información del Sistema
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="mr-3">
                            <i class="fas fa-user-shield fa-2x text-danger"></i>
                        </div>
                        <div>
                            <div class="small text-gray-500">Sesión activa como</div>
                            <div class="font-weight-bold">{{ Auth::user()->name }}</div>
                            <div class="small">
                                <span class="badge badge-danger">{{ Auth::user()->rol }}</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <p class="small text-gray-600 mb-0">
                        <i class="fas fa-clock mr-1"></i>
                        Fecha del sistema: <strong>{{ now()->format('d/m/Y H:i') }}</strong>
                    </p>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
<script>
// Gráfica de área — Actividad mensual
var ctxArea = document.getElementById("adminAreaChart");
var adminAreaChart = new Chart(ctxArea, {
    type: 'line',
    data: {
        labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        datasets: [{
            label: "Consultas",
            lineTension: 0.3,
            backgroundColor: "rgba(231,74,59,0.05)",
            borderColor: "rgba(231,74,59,1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(231,74,59,1)",
            pointBorderColor: "rgba(231,74,59,1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(231,74,59,1)",
            pointHoverBorderColor: "rgba(231,74,59,1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        }],
    },
    options: {
        maintainAspectRatio: false,
        layout: { padding: { left: 10, right: 25, top: 25, bottom: 0 } },
        scales: {
            xAxes: [{ gridLines: { display: false, drawBorder: false }, ticks: { maxTicksLimit: 7 } }],
            yAxes: [{ ticks: { maxTicksLimit: 5, padding: 10, beginAtZero: true }, gridLines: { color: "rgb(234, 236, 244)", drawBorder: false, borderDash: [2], borderDashOffset: [2] } }],
        },
        legend: { display: false },
        tooltips: { backgroundColor: "rgb(255,255,255)", bodyFontColor: "#858796", titleMarginBottom: 10, titleFontColor: '#6e707e', titleFontSize: 14, borderColor: '#dddfeb', borderWidth: 1, xPadding: 15, yPadding: 15, displayColors: false, intersect: false, mode: 'index', caretPadding: 10 }
    }
});

// Gráfica de donut — Distribución por rol
var ctxPie = document.getElementById("adminPieChart");
var adminPieChart = new Chart(ctxPie, {
    type: 'doughnut',
    data: {
        labels: ["Veterinarios", "Administradores"],
        datasets: [{
            data: [1, 1],
            backgroundColor: ['#4e73df', '#e74a3b'],
            hoverBackgroundColor: ['#2e59d9', '#c0392b'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
    },
    options: {
        maintainAspectRatio: false,
        tooltips: { backgroundColor: "rgb(255,255,255)", bodyFontColor: "#858796", borderColor: '#dddfeb', borderWidth: 1, xPadding: 15, yPadding: 15, displayColors: false, caretPadding: 10 },
        legend: { display: false },
        cutoutPercentage: 80,
    },
});
</script>
@endpush
