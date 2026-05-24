{{-- ===================== Sidebar ===================== --}}
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    {{-- Sidebar Brand --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-paw"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Veterinaria</div>
    </a>

    {{-- Divider --}}
    <hr class="sidebar-divider my-0">

    {{-- Heading: Consulta --}}
    <div class="sidebar-heading mt-3">
        Consulta
    </div>

    <li class="nav-item">
        <a class="nav-link pb-1" href="{{ (isset($mascota) && isset($consulta)) ? route('expedientes.consultas.diagnostico', [$mascota->id, $consulta->id]) : '#' }}">
            <i class="fas fa-fw fa-stethoscope"></i>
            <span>Diagnóstico</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link pt-1" href="{{ (isset($mascota) && isset($consulta)) ? route('expedientes.consultas.tratamiento', [$mascota->id, $consulta->id]) : '#' }}">
            <i class="fas fa-fw fa-pills"></i>
            <span>Tratamiento</span>
        </a>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider mt-3 mb-2">

    {{-- Heading: Antecedentes --}}
    <div class="sidebar-heading">
        Antecedentes
    </div>

    <li class="nav-item">
        <a class="nav-link pb-1" href="{{ isset($mascota) ? route('expedientes.mascotas.alergias', $mascota->id) : '#' }}">
            <i class="fas fa-fw fa-allergies"></i>
            <span>Alergias</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link py-1" href="{{ isset($mascota) ? route('expedientes.mascotas.lesiones', $mascota->id) : '#' }}">
            <i class="fas fa-fw fa-band-aid"></i>
            <span>Lesiones</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link pt-1" href="{{ isset($mascota) ? route('expedientes.mascotas.patologicos', $mascota->id) : '#' }}">
            <i class="fas fa-fw fa-disease"></i>
            <span>Patológicos</span>
        </a>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider mt-3 mb-2">

    {{-- Heading: Nutrición --}}
    <div class="sidebar-heading">
        Nutrición
    </div>

    <li class="nav-item">
        <a class="nav-link pb-3" href="{{ isset($mascota) ? route('expedientes.mascotas.nutricion', $mascota->id) : '#' }}">
            <i class="fas fa-fw fa-bone"></i>
            <span>Historial Alimentación</span>
        </a>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider d-none d-md-block">

    {{-- Sidebar Toggler --}}
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
{{-- ===================== End of Sidebar ===================== --}}
