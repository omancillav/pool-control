@extends('adminlte::page')

@section('title', 'Asistencias')

@section('content_header')
    <h1>Asistencias</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                @if(auth()->user()->rol == 'Cliente')
                    Mis Asistencias
                @else
                    Gestión de Asistencias
                @endif
            </h3>
            @if(auth()->user()->rol != 'Cliente')
                <div class="card-tools">
                    <a href="{{ route('asistencias.gestion') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-check-circle"></i> Gestionar Asistencias
                    </a>
                </div>
            @endif
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session('success') }}
                </div>
            @endif

            @if($asistencias->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Clase</th>
                                <th>Fecha</th>
                                @if(auth()->user()->rol != 'Cliente')
                                    <th>Cliente</th>
                                @endif
                                <th>Asistencia</th>
                                <th>Observaciones</th>
                                <th>Marcado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asistencias as $asistencia)
                                <tr>
                                    <td>Clase de {{ $asistencia->clase->nivel }}</td>
                                    <td>{{ \Carbon\Carbon::parse($asistencia->clase->fecha)->format('d/m/Y') }}</td>
                                    @if(auth()->user()->rol != 'Cliente')
                                        <td>{{ $asistencia->usuario->name }}</td>
                                    @endif
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
                                    <td>{{ $asistencia->observaciones ?? '-' }}</td>
                                    <td>{{ $asistencia->fecha_marcado->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('asistencias.show', $asistencia->id) }}" 
                                           class="btn btn-info btn-xs" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
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
                    <p>
                        @if(auth()->user()->rol == 'Cliente')
                            Aún no tienes asistencias registradas. Las asistencias se marcan cuando asistes a las clases reservadas.
                        @else
                            No hay asistencias registradas en el sistema.
                        @endif
                    </p>
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
