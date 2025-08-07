@extends('adminlte::page')

@section('title', 'Marcar Asistencias')

@section('content_header')
    <h1>Marcar Asistencias</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Clase de {{ $clase->nivel }} - {{ \Carbon\Carbon::parse($clase->fecha)->format('d/m/Y') }}
            </h3>
            <div class="card-tools">
                <a href="{{ route('asistencias.gestion') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($usuariosReservados->count() > 0)
                <form method="POST" action="{{ route('asistencias.guardar', $clase->id) }}">
                    @csrf
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Instrucciones:</strong> Marca la casilla para indicar que el cliente asistió a la clase. 
                        Opcionalmente puedes agregar observaciones sobre la asistencia.
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="50">Presente</th>
                                    <th>Cliente</th>
                                    <th>Email</th>
                                    <th>Membresía</th>
                                    <th>Observaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($usuariosReservados as $usuario)
                                    @php
                                        $asistenciaMarcada = $asistenciasMarcadas->get($usuario->id);
                                    @endphp
                                    <tr>
                                        <td class="text-center">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" 
                                                       class="custom-control-input" 
                                                       id="presente_{{ $usuario->id }}"
                                                       name="asistencias[{{ $usuario->id }}][presente]"
                                                       {{ $asistenciaMarcada && $asistenciaMarcada->presente ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="presente_{{ $usuario->id }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <strong>{{ $usuario->name }}</strong>
                                            @if($asistenciaMarcada)
                                                <br><small class="text-success">
                                                    <i class="fas fa-check"></i> Ya marcado
                                                    ({{ $asistenciaMarcada->fecha_marcado->format('d/m/Y H:i') }})
                                                </small>
                                            @endif
                                        </td>
                                        <td>{{ $usuario->email }}</td>
                                        <td>
                                            @if($usuario->membresia)
                                                <span class="badge badge-info">{{ $usuario->membresia->tipo }}</span>
                                            @else
                                                <span class="badge badge-secondary">Sin membresía</span>
                                            @endif
                                        </td>
                                        <td>
                                            <textarea class="form-control form-control-sm" 
                                                      name="asistencias[{{ $usuario->id }}][observaciones]"
                                                      rows="2" 
                                                      placeholder="Observaciones opcionales...">{{ $asistenciaMarcada ? $asistenciaMarcada->observaciones : '' }}</textarea>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Guardar Asistencias
                            </button>
                            <a href="{{ route('asistencias.gestion') }}" class="btn btn-secondary ml-2">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </div>
                </form>
            @else
                <div class="alert alert-warning text-center">
                    <h5><i class="fas fa-exclamation-triangle"></i> Sin reservaciones</h5>
                    <p>Esta clase no tiene usuarios reservados. No es posible marcar asistencias.</p>
                    <a href="{{ route('asistencias.gestion') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver a Gestión
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
        .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #28a745;
            border-color: #28a745;
        }
    </style>
@stop

@section('js')
<script>
    $(document).ready(function() {
        // Marcar/desmarcar todos
        $('#marcar-todos').on('change', function() {
            $('.asistencia-checkbox').prop('checked', $(this).prop('checked'));
        });

        // Actualizar el estado de "marcar todos" cuando cambian las casillas individuales
        $('.asistencia-checkbox').on('change', function() {
            var total = $('.asistencia-checkbox').length;
            var marcados = $('.asistencia-checkbox:checked').length;
            $('#marcar-todos').prop('checked', total === marcados);
        });
    });
</script>
@stop
