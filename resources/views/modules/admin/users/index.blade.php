@extends('layouts.admin')

@section('title', 'Gestión de Usuarios')

@section('contenido')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Usuarios</h1>
    </div>

    <!-- Mensajes de Éxito -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Mensajes de Error -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-12">
            <!-- Table Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-users"></i> Lista de Usuarios</h6>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary shadow-sm">
                        <i class="fas fa-plus fa-sm text-white-50"></i> Nuevo Usuario
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Correo Electrónico</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            {{ $user->name }}
                                            @if($user->rol === 'veterinario')
                                                <i class="fas fa-stethoscope text-info ml-1"></i>
                                            @endif
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->rol === 'administrador')
                                                <span class="badge badge-primary">Administrador</span>
                                            @else
                                                <span class="badge badge-success">Veterinario</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-success">Activo</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm" title="Editar"><i class="fas fa-edit"></i></a>
                                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-danger btn-sm" title="Eliminar"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No hay usuarios registrados por el momento.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
