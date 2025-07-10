<div class="row">
    <div class="col-12 mb-4">
        <h3>Bienvenido, Profesor</h3>
        <p class="text-muted">Aquí está tu calendario de clases</p>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title mb-0">Próximas Clases</h5>
                    <a href="{{ route('clases.list') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-plus mr-1"></i> Nueva Clase
                    </a>
                </div>

                @if(count($clasesImpartidas) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="border-0">Fecha y Hora</th>
                                    <th class="border-0">Tipo de Clase</th>
                                    <th class="border-0 text-center">Asistencia</th>
                                    <th class="border-0 text-right">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clasesImpartidas as $clase)
                                    <tr>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light p-2 rounded-circle mr-3">
                                                    <i class="fas fa-calendar-alt text-muted"></i>
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold">{{ $clase->fecha->format('d M') }}</div>
                                                    <div class="text-muted small">{{ $clase->fecha->format('H:i') }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="font-weight-bold">{{ $clase->tipo }}</div>
                                            <div class="text-muted small">{{ $clase->lugar ?? 'Sin ubicación' }}</div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="font-weight-bold">{{ $clase->lugares_ocupados }}</span>
                                            <span class="text-muted">/{{ $clase->lugares }}</span>
                                        </td>
                                        <td class="align-middle text-right">
                                            @if($clase->lugares_disponibles > 0)
                                                <span class="badge badge-light border text-success">
                                                    <i class="fas fa-circle mr-1"></i> Disponible
                                                </span>
                                            @else
                                                <span class="badge badge-light border text-danger">
                                                    <i class="fas fa-circle mr-1"></i> Completo
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-calendar-alt fa-4x text-muted mb-3"></i>
                            <h5>No tienes clases programadas</h5>
                            <p class="text-muted mb-4">Cuando tengas clases asignadas, aparecerán aquí</p>
                            <a href="{{ route('clases.nueva') }}" class="btn btn-primary">
                                <i class="fas fa-plus mr-2"></i> Crear Nueva Clase
                            </a>
                        </div>
                    </div>
                @endif
            </div>
            
            @if(count($clasesImpartidas) > 0)
                <div class="card-footer bg-transparent border-top-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Mostrando {{ $clasesImpartidas->count() }} clases
                        </div>
                        <a href="{{ route('clases.list') }}" class="btn btn-sm btn-outline-primary">
                            Ver todas las clases <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
