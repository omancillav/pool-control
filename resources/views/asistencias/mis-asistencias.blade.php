@extends('adminlte::page')

@section('title', 'Mis Asistencias')

@section('content_header')
    <h1>Mis Asistencias</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Historial de Asistencias</h3>
        </div>
        <div class="card-body">
            @if($asistencias->count() > 0)
                <!-- Resumen estadístico -->
                @php
                    $totalAsistencias = $asistencias->total();
                    $totalPresente = $asistencias->where('presente', true)->count();
                    $totalAusente = $asistencias->where('presente', false)->count();
                    $porcentajeAsistencia = $totalAsistencias > 0 ? round(($totalPresente / $totalAsistencias) * 100, 1) : 0;
                @endphp

                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="info-box bg-success">
                            <span class="info-box-icon"><i class="fas fa-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Presente</span>
                                <span class="info-box-number">{{ $totalPresente }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box bg-danger">
                            <span class="info-box-icon"><i class="fas fa-times"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Ausente</span>
                                <span class="info-box-number">{{ $totalAusente }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fas fa-chart-bar"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">% Asistencia</span>
                                <span class="info-box-number">{{ $porcentajeAsistencia }}%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box bg-primary">
                            <span class="info-box-icon"><i class="fas fa-list"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total</span>
                                <span class="info-box-number">{{ $totalAsistencias }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Clase</th>
                                <th>Nivel</th>
                                <th>Fecha</th>
                                <th>Profesor</th>
                                <th>Asistencia</th>
                                <th>Observaciones</th>
                                <th>Marcado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asistencias as $asistencia)
                                <tr>
                                    <td>Clase de {{ $asistencia->clase->nivel }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ $asistencia->clase->nivel }}</span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($asistencia->clase->fecha)->format('d/m/Y') }}</td>
                                    <td>{{ $asistencia->clase->profesor->name }}</td>
                                    <td>
                                        @if($asistencia->presente)
                                            <span class="badge badge-success">
                                                <i class="fas fa-check"></i> Presente
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                <i class="fas fa-times"></i> Ausente
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($asistencia->observaciones)
                                            <span class="text-muted" data-toggle="tooltip" 
                                                  title="{{ $asistencia->observaciones }}">
                                                <i class="fas fa-comment"></i> Ver nota
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $asistencia->fecha_marcado->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-center">
                    {{ $asistencias->links() }}
                </div>
            @else
                <div class="alert alert-info text-center">
                    <h5><i class="fas fa-info-circle"></i> Sin asistencias registradas</h5>
                    <p>Aún no tienes asistencias registradas. Las asistencias se marcan cuando asistes a las clases que has reservado.</p>
                    <a href="{{ route('reservaciones.index') }}" class="btn btn-primary">
                        <i class="fas fa-calendar-plus"></i> Ver Clases Disponibles
                    </a>
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
        .info-box {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        }
    </style>
@stop

@section('js')
<script>
    $(document).ready(function() {
        // Activar tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@stop
