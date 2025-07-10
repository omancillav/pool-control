@extends('adminlte::page')

@section('title', ' | Membresías')

@section('css')
<style>
    body {
        background: #E6F0FA;
    }
    .header-wave {
        position: relative;
        background: linear-gradient(90deg, #E6F0FA 0%, #B3D4FC 100%);
        overflow: hidden;
        border-radius: 0 0 32px 32px;
        box-shadow: 0 2px 8px rgba(176,190,197,0.12);
        padding: 16px 24px;
    }
    .wave-svg {
        position: absolute;
        left: 0; right: 0; bottom: 0;
        width: 100%; height: 70px;
        z-index: 0;
    }
    .wibesand-logo {
        font-weight: bold;
        font-size: 2rem;
        color: #FFC107;
        letter-spacing: 2px;
        display: flex;
        align-items: center;
        z-index: 1;
        position: relative;
    }
    .wibesand-logo .logo-icon {
        width: 36px; height: 36px; margin-right: 10px;
        background: #1976D2;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
    }
    .main-content {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(176,190,197,0.12);
        padding: 32px 16px 24px 16px;
        margin-bottom: 28px;
        border: 1px solid #E0E0E0;
    }
    .x_title {
        font-size: 2rem;
        font-weight: bold;
        color: #222;
        margin-bottom: 1rem;
        text-align: center;
    }
    .input-group {
        max-width: 400px;
        margin-bottom: 24px;
    }
    .input-group .form-control {
        border-radius: 6px 0 0 6px;
        border: 1px solid #E0E0E0;
        box-shadow: 0 2px 4px rgba(176,190,197,0.1);
    }
    .input-group .btn-primary {
        background: #1976D2;
        border: 1px solid #1976D2;
        border-radius: 0 6px 6px 0;
        font-weight: bold;
    }
    .table {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #E0E0E0;
        box-shadow: 0 2px 8px rgba(176,190,197,0.12);
    }
    .table th {
        background: #F5F7FA;
        color: #222;
        font-weight: bold;
        border-bottom: 2px solid #E0E0E0;
    }
    .table td {
        vertical-align: middle;
        color: #333;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #F9FAFB;
    }
    .btn-edit {
        background: #1976D2;
        border: 1px solid #1976D2;
        border-radius: 6px;
        font-size: 0.9rem;
        padding: 6px 12px;
        color: #fff;
    }
    .btn-delete {
        background: #0D47A1;
        border: 1px solid #0D47A1;
        border-radius: 6px;
        font-size: 0.9rem;
        padding: 6px 12px;
        color: #fff;
    }
    .pagination .page-link {
        border-radius: 6px;
        margin: 0 4px;
        color: #1976D2;
        border: 1px solid #E0E0E0;
    }
    .pagination .page-item.active .page-link {
        background: #1976D2;
        border-color: #1976D2;
        color: #fff;
    }
</style>
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
                <div class="x_title">
                    <h2>Membresías</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="col-lg-4">
                    <form method="GET" action="{{ route('membresias.list') }}" class="my-3">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Buscar..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <table id="membresias" class="table table-striped display responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Cliente</th>
                                            <th>Clases Adquiridas</th>
                                            <th>Clases Disponibles</th>
                                            <th>Clases Ocupadas</th>
                                            <th>Creado el</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($membresias as $membresia)
                                            <tr>
                                                <td>{{ $membresia->id }}</td>
                                                <td>{{ $membresia->usuario->name ?? 'Sin nombre' }}</td>
                                                <td>{{ $membresia->clases_adquiridas }}</td>
                                                <td>{{ $membresia->clases_disponibles }}</td>
                                                <td>{{ $membresia->clases_ocupadas }}</td>
                                                <td>{{ $membresia->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Opciones">
                                                        <button type="button" class="btn btn-edit mr-2" title="Editar" data-toggle="modal"
                                                            data-target="#editMembresia{{ $membresia->id }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-delete mr-2" title="Eliminar" data-toggle="modal"
                                                            data-target="#delete{{ $membresia->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                @include('membresias.edit')
                                                @include('membresias.delete')
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No se encontraron resultados.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center mt-3">
                                    {!! $membresias->links('pagination::bootstrap-4') !!}
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
            $('#membresias').DataTable({
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