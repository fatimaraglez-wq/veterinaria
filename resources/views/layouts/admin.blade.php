<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Panel de Administración — Sistema Veterinaria">
    <meta name="author" content="Veterinaria">

    <title>@yield('titulo_pagina', 'Administrador') | Admin Veterinaria</title>

    {{-- FontAwesome --}}
    <link href="/startbootstrap/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    {{-- SB Admin 2 CSS --}}
    <link href="/startbootstrap/css/sb-admin-2.min.css" rel="stylesheet">
    
    {{-- Custom Pink & Purple Theme --}}
    <link href="/css/pink-purple-theme.css" rel="stylesheet">

    @stack('styles')
</head>

<body id="page-top">

    {{-- ===================== Page Wrapper ===================== --}}
    <div id="wrapper">

        {{-- Sidebar Admin --}}
        @if(!View::hasSection('hide_sidebar'))
            @include('partials.admin.sidebar')
        @endif
        {{-- End of Sidebar --}}

        {{-- Content Wrapper --}}
        <div id="content-wrapper" class="d-flex flex-column">

            {{-- Main Content --}}
            <div id="content">

                {{-- Topbar Admin --}}
                @include('partials.admin.topbar')
                {{-- End of Topbar --}}

                {{-- Begin Page Content --}}
                <div class="container-fluid">
                    @yield('contenido')
                </div>
                {{-- /.container-fluid --}}

            </div>
            {{-- End of Main Content --}}

            {{-- Footer Admin --}}
            @include('partials.admin.footer')
            {{-- End of Footer --}}

        </div>
        {{-- End of Content Wrapper --}}

    </div>
    {{-- End of Page Wrapper --}}

    {{-- Scroll to Top Button --}}
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    {{-- Logout Modal --}}
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">¿Listo para salir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecciona "Cerrar Sesión" si deseas terminar tu sesión actual.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-danger" href="{{ route('logout') }}">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap core JS --}}
    <script src="/startbootstrap/vendor/jquery/jquery.min.js"></script>
    <script src="/startbootstrap/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    {{-- Core plugin JS --}}
    <script src="/startbootstrap/vendor/jquery-easing/jquery.easing.min.js"></script>

    {{-- Chart.js --}}
    <script src="/startbootstrap/vendor/chart.js/Chart.min.js"></script>

    {{-- SB Admin 2 JS --}}
    <script src="/startbootstrap/js/sb-admin-2.min.js"></script>

    @stack('scripts')

</body>

</html>
