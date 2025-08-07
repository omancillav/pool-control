@extends('adminlte::page')

@section('title', 'Detalle de Asistencia')

@section('content_header')
    <h1>Detalle de Asistencia</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información de la Asistencia</h3>
            <div class="card-tools">
                <a href="{{ route('asistencias.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-swimming-pool"></i> Información de la Clase
                            </h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Clase:</strong></td>
                                    <td>Clase de {{ $asistencia->clase->nivel }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nivel:</strong></td>
                                    <td>
                                        <span class="badge badge-info">{{ $asistencia->clase->nivel }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Fecha:</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($asistencia->clase->fecha)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Profesor:</strong></td>
                                    <td>{{ $asistencia->clase->profesor->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Descripción:</strong></td>
                                    <td>{{ $asistencia->clase->descripcion ?? 'Sin descripción' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user-check"></i> Información del Cliente
                            </h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Nombre:</strong></td>
                                    <td>{{ $asistencia->usuario->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $asistencia->usuario->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Rol:</strong></td>
                                    <td>
                                        <span class="badge badge-secondary">{{ $asistencia->usuario->rol }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Membresía:</strong></td>
                                    <td>
                                        @if($asistencia->usuario->membresia)
                                            <span class="badge badge-info">{{ $asistencia->usuario->membresia->tipo }}</span>
                                        @else
                                            <span class="badge badge-secondary">Sin membresía</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de la asistencia -->
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-clipboard-check"></i> Detalles de la Asistencia
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon {{ $asistencia->presente ? 'bg-success' : 'bg-danger' }}">
                                    <i class="fas {{ $asistencia->presente ? 'fa-check' : 'fa-times' }}"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Estado</span>
                                    <span class="info-box-number">
                                        {{ $asistencia->presente ? 'Presente' : 'Ausente' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box bg-info">
                                <span class="info-box-icon">
                                    <i class="fas fa-clock"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Marcado</span>
                                    <span class="info-box-number text-sm">
                                        {{ $asistencia->fecha_marcado->format('d/m/Y') }}<br>
                                        {{ $asistencia->fecha_marcado->format('H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($asistencia->observaciones)
                        <div class="alert alert-light mt-3">
                            <h6><i class="fas fa-comment"></i> Observaciones:</h6>
                            <p class="mb-0">{{ $asistencia->observaciones }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .table th {
            font-weight: 600;
        }
        .info-box {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        }
        .card-outline {
            border-top: 3px solid;
        }
    </style>
@stop
