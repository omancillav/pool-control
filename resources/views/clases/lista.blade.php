@extends('adminlte::page')

@section('title', ' | Clases')

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
    .form-header {
        background: linear-gradient(90deg, #E6F0FA 0%, #B3D4FC 100%);
        border-radius: 12px 12px 0 0;
        padding: 16px 24px;
        margin: -32px -16px 24px -16px;
        box-shadow: 0 2px 4px rgba(176,190,197,0.1);
    }
    .form-title {
        font-size: 1.8rem;
        font-weight: bold;
        color: #222;
        margin: 0;
    }
    .form-control {
        border-radius: 6px;
        border: 1px solid #E0E0E0;
        box-shadow: 0 2px 4px rgba(176,190,197,0.1);
    }
    .btn-search {
        background: #1976D2;
        border: 1px solid #1976D2;
        color: #fff;
        border-radius: 6px;
        font-weight: bold;
        padding: 8px 16px;
    }
    .btn-edit {
        background: #1976D2;
        border: 1px solid #1976D2;
        color: #fff;
        border-radius: 6px;
        font-weight: bold;
        padding: 8px 12px;
    }
    .btn-delete {
        background: #DC3545;
        border: 1px solid #DC3545;
        color: #fff;
        border-radius: 6px;
        font-weight: bold;
        padding: 8px 12px;
    }
    .table {
        border-radius: 6px;
        border: 1px solid #E0E0E0;
        box-shadow: 0 2px 4px rgba(176,190,197,0.1);
        background: #fff;
    }
    .table thead th {
        font-weight: bold;
        color: #222;
        background: #F8F9FA;
    }
    .table tbody tr {
        border-bottom: 1px solid #E0E0E0;
    }
    .pagination .page-link {
        border-radius: 6px;
        border: 1px solid #E0E0E0;
        color: #1976D2;
    }
    .pagination .page-item.active .page-link {
        background: #1976D2;
        border-color: #1976D2;
        color: #fff;
    }
</style>
@endsection

@section('content_header')
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
@endsection

@section('content')
    <div class="main-content">
        <div class="form-header">
            <h3 class="form-title">Clases</h3>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <form method="GET" action="{{ route('clases.list') }}" class="my-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Buscar..."
                            value="{{ request('search') }}" aria-describedby="search-button">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-search" id="search-button">Buscar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table id="clases" class="table table-striped display responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Profesor</th>
                        <th>Tipo</th>
                        <th>Lugares</th>
                        <th>Lugares Ocupados</th>
                        <th>Lugares Disponibles</th>
                        <th>Creado el</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clases as $clase)
                        <tr>
                            <td>{{ $clase->id }}</td>
                            <td>{{ $clase->fecha->format('d/m/Y') }}</td>
                            <td>{{ $clase->profesor->name ?? 'Sin asignar' }} {{ $clase->profesor->last_name ?? '' }}</td>
                            <td>{{ $clase->tipo }}</td>
                            <td>{{ $clase->lugares }}</td>
                            <td>{{ $clase->lugares_ocupados }}</td>
                            <td>{{ $clase->lugares_disponibles }}</td>
                            <td>{{ $clase->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Opciones">
                                    <button type="button" class="btn btn-edit mr-2" title="Editar"
                                        data-toggle="modal" data-target="#editClase{{ $clase->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-delete mr-2" title="Eliminar"
                                        data-toggle="modal" data-target="#delete{{ $clase->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                            @include('clases.edit')
                            @include('clases.delete')
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No se encontraron resultados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {!! $clases->links('pagination::bootstrap-4') !!}
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#clases').DataTable({
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