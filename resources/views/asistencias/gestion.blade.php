@extends('adminlte::page')

@section('title', 'Gestión de Asistencias')

@section('content_header')
    <h1>Gestión de Asistencias</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Clases para Marcar Asistencia</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session('success') }}
                </div>
            @endif

            @if($clases->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Clase</th>
                                <th>Nivel</th>
                                <th>Fecha</th>
                                <th>Profesor</th>
                                <th>Reservaciones</th>
                                <th>Asistencias</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clases as $clase)
                                <tr>
                                    <td>Clase de {{ $clase->nivel }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ $clase->nivel }}</span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($clase->fecha)->format('d/m/Y') }}</td>
                                    <td>{{ $clase->profesor->name }}</td>
                                    <td>
                                        <span class="badge badge-primary">
                                            {{ $clase->reservaciones->count() }} reservados
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $asistenciasMarcadas = $clase->asistencias->count();
                                            $totalReservaciones = $clase->reservaciones->count();
                                        @endphp
                                        <span class="badge {{ $asistenciasMarcadas > 0 ? 'badge-success' : 'badge-secondary' }}">
                                            {{ $asistenciasMarcadas }}/{{ $totalReservaciones }} marcadas
                                        </span>
                                    </td>
                                    <td>
                                        @if($clase->reservaciones->count() > 0)
                                            <a href="{{ route('asistencias.marcar', $clase->id) }}" 
                                               class="btn btn-success btn-sm" title="Marcar Asistencias">
                                                <i class="fas fa-check-circle"></i> Marcar
                                            </a>
                                        @else
                                            <span class="text-muted">Sin reservaciones</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-center">
                    {{ $clases->links() }}
                </div>
            @else
                <div class="alert alert-info text-center">
                    <h5><i class="fas fa-info-circle"></i> No hay clases disponibles</h5>
                    <p>No hay clases programadas para marcar asistencias.</p>
                </div>
            @endif
        </div>
    </div>
@stop

@section('css')
    <style>
        .table th {
            font-weight: 600;
        }
        .badge {
            font-size: 0.9em;
        }
    </style>
@stop

@section('js')
<script>
    // Auto-ocultar alertas después de 5 segundos
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
</script>
@stop
