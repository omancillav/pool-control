<div class="row">
    <div class="col-12 mb-4">
        <h3>Bienvenido de vuelta</h3>
        <p class="text-muted">Aquí está el resumen de tu actividad</p>
    </div>
</div>

<div class="row">
    <div class="col-12 col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title mb-4">Tu Membresía</h5>
                @if($membresia)
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-light p-3 rounded-circle mr-3">
                            <i class="fas fa-id-card text-muted"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 text-muted">Clases Disponibles</h6>
                            <h3 class="mb-0">{{ $membresia->clases_disponibles ?? '0' }}</h3>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted small">Progreso</span>
                            <span class="text-muted small">{{ $membresia->clases_ocupadas }} de {{ $membresia->clases_adquiridas }}</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ ($membresia->clases_adquiridas > 0) ? ($membresia->clases_ocupadas / $membresia->clases_adquiridas) * 100 : 0 }}%" 
                                 aria-valuenow="{{ $membresia->clases_ocupadas }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="{{ $membresia->clases_adquiridas }}">
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <div class="mb-3">
                            <i class="fas fa-id-card fa-3x text-muted mb-3"></i>
                            <p class="mb-4">No tienes una membresía activa</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title mb-0">Próximas Clases</h5>
                    <a href="{{ route('clases.list') }}" class="small text-primary">Ver todas</a>
                </div>
                
                @if(count($clases) > 0)
                    <div class="list-group list-group-flush">
                        @foreach($clases as $clase)
                            <div class="list-group-item px-0 border-0">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light p-2 rounded-circle mr-3">
                                        <i class="fas fa-swimmer text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $clase->tipo }}</h6>
                                        <p class="mb-0 small text-muted">
                                            {{ $clase->fecha->format('d M, H:i') }}
                                            @if($clase->profesor)
                                                • {{ $clase->profesor->name }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                        <p class="mb-0 text-muted">No tienes clases programadas</p>
                        <a href="{{ route('clases.list') }}" class="btn btn-sm btn-outline-primary mt-3">Ver Clases Disponibles</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
