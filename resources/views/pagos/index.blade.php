@extends('adminlte::page')

@section('title', 'Gestión de Pagos')

@section('content_header')
    <h1>Gestión de Pagos</h1>
@stop

@section('content')
<div class="container-fluid">
    <!-- Filtros de búsqueda -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-filter"></i> Filtros</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('pagos.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="search">Buscar</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   placeholder="Usuario, email, nivel de clase o número de transacción..." 
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="metodo_pago">Método de Pago</label>
                            <select class="form-control" id="metodo_pago" name="metodo_pago">
                                <option value="">Todos</option>
                                <option value="online" {{ request('metodo_pago') == 'online' ? 'selected' : '' }}>Online</option>
                                <option value="fisico" {{ request('metodo_pago') == 'fisico' ? 'selected' : '' }}>Físico</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select class="form-control" id="estado" name="estado">
                                <option value="">Todos</option>
                                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="completado" {{ request('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
                                <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de pagos -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-money-bill"></i> Lista de Pagos</h3>
        </div>
        <div class="card-body table-responsive">
            @if($pagos->count() > 0)
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Clase</th>
                        <th>Monto</th>
                        <th>Método</th>
                        <th>Estado</th>
                        <th>Transacción</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pagos as $pago)
                    <tr>
                        <td>{{ $pago->id }}</td>
                        <td>
                            <strong>{{ $pago->usuario->name }}</strong><br>
                            <small class="text-muted">{{ $pago->usuario->email }}</small>
                        </td>
                        <td>
                            <strong>{{ $pago->reservacion->clase->nivel }}</strong><br>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($pago->reservacion->clase->fecha)->format('d/m/Y') }}
                                - {{ $pago->reservacion->clase->profesor->name }}
                            </small>
                        </td>
                        <td>
                            <strong>${{ number_format($pago->monto, 2) }}</strong>
                        </td>
                        <td>
                            @if($pago->metodo_pago == 'online')
                                <span class="badge badge-success"><i class="fas fa-credit-card"></i> Online</span>
                            @else
                                <span class="badge badge-warning"><i class="fas fa-money-bill"></i> Físico</span>
                            @endif
                        </td>
                        <td>
                            @switch($pago->estado)
                                @case('completado')
                                    <span class="badge badge-success"><i class="fas fa-check"></i> Completado</span>
                                    @break
                                @case('pendiente')
                                    <span class="badge badge-warning"><i class="fas fa-clock"></i> Pendiente</span>
                                    @break
                                @case('cancelado')
                                    <span class="badge badge-danger"><i class="fas fa-times"></i> Cancelado</span>
                                    @break
                            @endswitch
                        </td>
                        <td>
                            @if($pago->numero_transaccion)
                                <small class="font-monospace">{{ $pago->numero_transaccion }}</small>
                            @else
                                <small class="text-muted">-</small>
                            @endif
                        </td>
                        <td>
                            {{ $pago->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                @if($pago->estado == 'pendiente' && $pago->metodo_pago == 'fisico')
                                    <form method="POST" action="{{ route('pagos.marcar-completado', $pago->id) }}" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success" 
                                                onclick="return confirm('¿Marcar este pago como completado?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                                
                                @if($pago->estado != 'cancelado')
                                    <form method="POST" action="{{ route('pagos.cancelar', $pago->id) }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('¿Cancelar este pago y la reservación? Esta acción no se puede deshacer.')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Paginación -->
            <div class="d-flex justify-content-center">
                {{ $pagos->appends(request()->query())->links() }}
            </div>
            @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> No se encontraron pagos con los filtros seleccionados.
            </div>
            @endif
        </div>
    </div>

    <!-- Resumen estadístico -->
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-info">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{ $pagos->where('estado', 'completado')->count() }}</span>
                                <span>Pagos Completados</span>
                            </p>
                        </div>
                        <div class="ml-auto">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{ $pagos->where('estado', 'pendiente')->count() }}</span>
                                <span>Pagos Pendientes</span>
                            </p>
                        </div>
                        <div class="ml-auto">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{ $pagos->where('metodo_pago', 'online')->count() }}</span>
                                <span>Pagos Online</span>
                            </p>
                        </div>
                        <div class="ml-auto">
                            <i class="fas fa-credit-card fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-secondary">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">${{ number_format($pagos->where('estado', 'completado')->sum('monto'), 2) }}</span>
                                <span>Total Recaudado</span>
                            </p>
                        </div>
                        <div class="ml-auto">
                            <i class="fas fa-dollar-sign fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
