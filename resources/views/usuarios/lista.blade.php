@extends('adminlte::page')

@section('title', ' | Usuarios')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/list.css') }}">
@endsection

@section('content')
    <div class="header-wave">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div class="wibesand-logo">
                <span class="logo-icon">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Logo de Pool Control" style="width:32px; height:32px; border-radius:50%; object-fit:cover; background:#1976D2;" />
                </span>
                Pool Control
            </div>
            <div></div>
        </div>
        <svg class="wave-svg" viewBox="0 0 1440 70" preserveAspectRatio="none">
            <path d="M0,70 C360,30 1080,110 1440,70 L1440,70 L0,70 Z" fill="#fff"/>
        </svg>
    </div>

    <section class="content main-content">
        <div class="right_col" role="main">
            <div class="col-md-12 col-sm-12">
                                <div class="content-header">
                    <h2 class="page-title">Usuarios</h2>
                </div>

                    <div class="col-lg-4">
                        <form method="GET" action="{{ route('usuarios.list') }}" class="my-3">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Buscar..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                                                    <button type="submit" class="btn btn-search">Buscar</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <table id="usuarios" class="table table-striped display responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Email</th>
                                                <th>Rol</th>
                                                <th>Creado el</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($usuarios as $usuario)
                                                <tr>
                                                    <td>{{ $usuario->id }}</td>
                                                    <td>{{ $usuario->name }}</td>
                                                    <td>{{ $usuario->email }}</td>
                                                    <td>{{ $usuario->rol }}</td>
                                                    <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                                                    <td>
                                                        <div class="btn-group" role="group" aria-label="Opciones">
                                                            <button type="button" class="btn btn-edit mr-2" title="Editar" data-toggle="modal" data-target="#editUsuario{{ $usuario->id }}">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-delete mr-2" title="Eliminar" data-toggle="modal" data-target="#delete{{ $usuario->id }}">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    @include('usuarios.edit')
                                                    @include('usuarios.delete')
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">No se encontraron resultados.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                    <div class="d-flex justify-content-center mt-3">
                                        {!! $usuarios->links('pagination::bootstrap-4') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#usuarios').DataTable({
                responsive: true,
                paging: false,
                info: false,
                searching: false,
                order: [[0, 'desc']],
                dom: 'Bfrtip',
            });

            var successMessage = "{{ session('success') }}";
            var errorMessage = "{{ session('error') }}";

            if (successMessage) {
                Swal.fire({
                    title: 'Éxito',
                    text: successMessage,
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });
            }

            if (errorMessage) {
                Swal.fire({
                    title: 'Error',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    </script>
@endsection
