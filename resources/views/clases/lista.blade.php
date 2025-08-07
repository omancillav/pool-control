@extends('adminlte::page')

@section('title', ' | Clases')

@section('css')
<link rel="stylesheet" href="{{ asset('css/panel.css') }}">
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
        <path d="M0,60 C360,70 1080,50 1440,60 L1440,70 L0,70 Z" fill="#f4f6f9" />
    </svg>
</div>
<div class="main-content">
    <div class="content-header">
        <h3 class="page-title">Clases</h3>
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
                    <!-- <th>ID</th> -->
                    <th>Fecha</th>
                    <th>Profesor</th>
                    <th>Nivel</th>
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
                    <!-- <td>{{ $clase->id }}</td> -->
                    <td>{{ $clase->fecha->format('d/m/Y') }}</td>
                    <td>{{ $clase->profesor->name ?? 'Sin asignar' }} {{ $clase->profesor->last_name ?? '' }}</td>
                    <td>{{ $clase->nivel }}</td>
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
    $(document).ready(function() {
        $('#clases').DataTable({
            responsive: true,
            paging: false,
            info: false,
            searching: false,
            order: [
                [0, 'desc']
            ],
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