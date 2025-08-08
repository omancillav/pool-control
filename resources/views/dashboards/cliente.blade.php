<div class="row">
    <div class="col-12 mb-4">
        <h3><i class="fas fa-swimmer text-primary"></i> ¡Bienvenido de vuelta, {{ Auth::user()->name }}!</h3>
        <p class="text-muted">Aquí está el resumen de tu actividad en Pool Control</p>
    </div>
</div>

<!-- Resumen rápido de estadísticas -->
<div class="row mb-4">
    <div class="col-md-3 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100 bg-gradient-primary text-white">
            <div class="card-body text-center">
                <i class="fas fa-id-card fa-2x mb-2"></i>
                <h4 class="mb-1">{{ $membresia ? $membresia->clases_disponibles : 0 }}</h4>
                <small>Clases Disponibles</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100 bg-gradient-success text-white">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-2x mb-2"></i>
                <h4 class="mb-1">{{ $membresia ? $membresia->clases_ocupadas : 0 }}</h4>
                <small>Clases Completadas</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100 bg-gradient-info text-white">
            <div class="card-body text-center">
                <i class="fas fa-calendar-check fa-2x mb-2"></i>
                <h4 class="mb-1">{{ count($reservaciones) }}</h4>
                <small>Reservaciones Activas</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100 bg-gradient-warning text-white">
            <div class="card-body text-center">
                <i class="fas fa-percentage fa-2x mb-2"></i>
                <h4 class="mb-1">{{ $membresia ? $membresia->porcentajeUtilizado() : 0 }}%</h4>
                <small>Progreso</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Estado de Membresía -->
    <div class="col-12 col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-id-card text-primary"></i> Tu Membresía
                    </h5>
                    @if($membresia)
                        <a href="{{ route('membresias.comprar') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-plus"></i> Agregar Clases
                        </a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if($membresia)
                    <div class="mb-4">
                        <div class="row">
                            <div class="col-6">
                                <div class="text-center p-3 bg-light rounded">
                                    <h3 class="text-primary mb-1">{{ $membresia->clases_disponibles }}</h3>
                                    <small class="text-muted">Clases Disponibles</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3 bg-light rounded">
                                    <h3 class="text-success mb-1">{{ $membresia->clases_adquiridas }}</h3>
                                    <small class="text-muted">Total Adquiridas</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Progreso de Utilización</span>
                            <span class="font-weight-bold">{{ $membresia->porcentajeUtilizado() }}%</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-gradient-primary" role="progressbar" 
                                 style="width: {{ $membresia->porcentajeUtilizado() }}%" 
                                 aria-valuenow="{{ $membresia->porcentajeUtilizado() }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>
                    </div>

                    <div class="row text-center">
                        <div class="col-4">
                            <h6 class="text-primary">{{ $membresia->clases_disponibles }}</h6>
                            <small class="text-muted">Disponibles</small>
                        </div>
                        <div class="col-4">
                            <h6 class="text-warning">{{ $membresia->clases_ocupadas }}</h6>
                            <small class="text-muted">Utilizadas</small>
                        </div>
                        <div class="col-4">
                            <h6 class="text-success">{{ $membresia->clases_adquiridas }}</h6>
                            <small class="text-muted">Total</small>
                        </div>
                    </div>

                    @if($membresia->clases_disponibles <= 2)
                        <div class="alert alert-warning mt-3" role="alert">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>¡Atención!</strong> Te quedan pocas clases disponibles. 
                            <a href="{{ route('membresias.comprar') }}" class="alert-link">Renueva tu membresía</a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-id-card fa-4x text-muted mb-4"></i>
                        <h5 class="text-muted">No tienes una membresía activa</h5>
                        <p class="text-muted mb-4">Para comenzar a reservar clases, necesitas adquirir una membresía.</p>
                        <a href="{{ route('membresias.comprar') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-cart"></i> Comprar Membresía
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Próximas Clases Reservadas -->
    <div class="col-12 col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar-alt text-success"></i> Próximas Clases
                    </h5>
                    <a href="{{ route('reservaciones.mis-reservaciones') }}" class="btn btn-outline-success btn-sm">
                        Ver Todas
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(count($reservaciones) > 0)
                    <div class="timeline">
                        @foreach($reservaciones as $reservacion)
                            <div class="timeline-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="timeline-marker bg-primary rounded-circle p-2 mr-3">
                                        <i class="fas fa-swimmer text-white fa-sm"></i>
                                    </div>
                                    <div class="timeline-content flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="mb-1 font-weight-bold">{{ $reservacion->clase->nivel }}</h6>
                                            <span class="badge badge-primary badge-pill">
                                                {{ \Carbon\Carbon::parse($reservacion->clase->fecha)->format('M d') }}
                                            </span>
                                        </div>
                                        <p class="text-muted mb-1 small">
                                            <i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($reservacion->clase->fecha)->format('d/m/Y') }}
                                        </p>
                                        <p class="text-muted mb-0 small">
                                            <i class="fas fa-user-tie"></i> {{ $reservacion->clase->profesor->name }}
                                        </p>
                                        @if($reservacion->notas)
                                            <p class="text-muted mb-0 small">
                                                <i class="fas fa-sticky-note"></i> {{ $reservacion->notas }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-times fa-4x text-muted mb-4"></i>
                        <h5 class="text-muted">No tienes clases reservadas</h5>
                        <p class="text-muted mb-4">Explora nuestras clases disponibles y reserva la que más te convenga.</p>
                        <a href="{{ route('reservaciones.index') }}" class="btn btn-success">
                            <i class="fas fa-search"></i> Explorar Clases
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Acciones Rápidas -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt text-warning"></i> Acciones Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('reservaciones.index') }}" class="btn btn-outline-primary btn-block h-100 d-flex flex-column justify-content-center align-items-center py-3">
                            <i class="fas fa-search fa-2x mb-2"></i>
                            <span>Explorar Clases</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('reservaciones.mis-reservaciones') }}" class="btn btn-outline-success btn-block h-100 d-flex flex-column justify-content-center align-items-center py-3">
                            <i class="fas fa-list fa-2x mb-2"></i>
                            <span>Mis Reservaciones</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('membresias.comprar') }}" class="btn btn-outline-info btn-block h-100 d-flex flex-column justify-content-center align-items-center py-3">
                            <i class="fas fa-plus fa-2x mb-2"></i>
                            <span>{{ $membresia ? 'Agregar Clases' : 'Comprar Membresía' }}</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('membresias.list') }}" class="btn btn-outline-secondary btn-block h-100 d-flex flex-column justify-content-center align-items-center py-3">
                            <i class="fas fa-chart-bar fa-2x mb-2"></i>
                            <span>Mi Historial</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}
.bg-gradient-success {
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
}
.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%);
}
.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107 0%, #d39e00 100%);
}

.timeline-marker {
    min-width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
</style>
