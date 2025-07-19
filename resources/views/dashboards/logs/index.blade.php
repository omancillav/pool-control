@extends('adminlte::page')

@section('title', 'Registro de Actividad')

@section('content_header')
    <h1>Registro de Actividad</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Descripción</th>
                        <th>Modelo</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th>Detalles</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activities as $activity)
                        <tr>
                            <td>{{ $activity->description }}</td>
                            <td>{{ $activity->log_name }}</td>
                            <td>{{ $activity->causer ? $activity->causer->name : 'Sistema' }}</td>
                            <td>{{ $activity->created_at->format('d/m/Y H:i:s') }}</td>
                            <td>
                                @if($activity->properties->count())
                                    <button class="btn btn-sm btn-info" type="button" data-toggle="collapse" data-target="#collapse-{{ $activity->id }}">
                                        Ver Cambios
                                    </button>
                                    <div class="collapse mt-2" id="collapse-{{ $activity->id }}">
                                        <pre class="bg-light p-2"><code>{{ json_encode($activity->properties, JSON_PRETTY_PRINT) }}</code></pre>
                                    </div>
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay actividades registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($activities->hasPages())
            <div class="card-footer">
                {{ $activities->links() }}
            </div>
        @endif
    </div>
@stop
