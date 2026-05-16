{{-- ===================== Sidebar Administrador ===================== --}}
<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    {{-- Sidebar Brand --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.home') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-shield-alt"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin <span class="font-weight-light">Panel</span></div>
    </a>

    {{-- Divider --}}
    <hr class="sidebar-divider my-0">

    {{-- Badge de rol --}}
    <div class="text-center mt-2 mb-1">
        <span class="badge badge-danger px-3 py-1" style="font-size: 0.7rem; letter-spacing: 0.05rem;">
            <i class="fas fa-user-shield mr-1"></i> ADMINISTRADOR
        </span>
    </div>

    {{-- Divider --}}
    <hr class="sidebar-divider">

    {{-- Nav Item - Dashboard --}}
    <li class="nav-item {{ request()->routeIs('admin.home') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider">

    {{-- Heading --}}
    <div class="sidebar-heading">
        Gestión
    </div>

    {{-- Nav Item - Usuarios Collapse Menu --}}
    <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->routeIs('admin.users.*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseUsuarios"
            aria-expanded="{{ request()->routeIs('admin.users.*') ? 'true' : 'false' }}" aria-controls="collapseUsuarios">
            <i class="fas fa-fw fa-users"></i>
            <span>Usuarios</span>
        </a>
        <div id="collapseUsuarios" class="collapse {{ request()->routeIs('admin.users.*') ? 'show' : '' }}" aria-labelledby="headingUsuarios" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestión de Usuarios:</h6>
                <a class="collapse-item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Listar usuarios</a>
            </div>
        </div>
    </li>

    {{-- Nav Item - Reportes --}}
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Reportes</span>
        </a>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider">

    {{-- Heading --}}
    <div class="sidebar-heading">
        Sistema
    </div>

    {{-- Nav Item - Configuración --}}
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-cog"></i>
            <span>Configuración</span>
        </a>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider d-none d-md-block">

    {{-- Sidebar Toggler --}}
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
{{-- ===================== End of Sidebar Administrador ===================== --}}
