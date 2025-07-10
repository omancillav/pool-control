<div class="row">
    <div class="col-12 mb-4">
        <h3 class="mb-4">Resumen General</h3>
    </div>
    
    <div class="col-12 col-sm-6 col-lg-4 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-light p-3 rounded-circle mr-3">
                        <i class="fas fa-users text-muted"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted">Usuarios</h6>
                        <h4 class="mb-0">{{ $totalUsuarios ?? '0' }}</h4>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top-0">
                <a href="{{ route('usuarios.list') }}" class="text-primary small">Ver detalles <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-4 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-light p-3 rounded-circle mr-3">
                        <i class="fas fa-id-card text-muted"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1">Membresías Activas</h6>
                        <h3 class="mb-0">{{ $totalMembresias }}</h3>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('membresias.index') }}" class="text-primary small font-weight-bold">
                        Ver membresías <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-md-4 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-light p-3 rounded-circle mr-3">
                        <i class="fas fa-calendar-alt text-muted"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1">Clases Programadas</h6>
                        <h3 class="mb-0">{{ $totalClases }}</h3>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('clases.index') }}" class="text-primary small font-weight-bold">
                        Ver clases <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">Acciones Rápidas</h5>
                <div class="row">
                    <div class="col-6 col-md-3 mb-4">
                        <a href="{{ route('usuarios.create') }}" class="text-decoration-none">
                            <div class="border rounded p-4 text-center h-100 hover-shadow">
                                <div class="bg-light p-3 rounded-circle d-inline-flex mb-3">
                                    <i class="fas fa-user-plus text-primary"></i>
                                </div>
                                <h6 class="mb-0">Nuevo Usuario</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3 mb-4">
                        <a href="{{ route('membresias.create') }}" class="text-decoration-none">
                            <div class="border rounded p-4 text-center h-100 hover-shadow">
                                <div class="bg-light p-3 rounded-circle d-inline-flex mb-3">
                                    <i class="fas fa-id-card text-primary"></i>
                                </div>
                                <h6 class="mb-0">Nueva Membresía</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3 mb-4">
                        <a href="{{ route('clases.create') }}" class="text-decoration-none">
                            <div class="border rounded p-4 text-center h-100 hover-shadow">
                                <div class="bg-light p-3 rounded-circle d-inline-flex mb-3">
                                    <i class="fas fa-calendar-plus text-primary"></i>
                                </div>
                                <h6 class="mb-0">Nueva Clase</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3 mb-4">
                        <a href="{{ route('reportes.index') }}" class="text-decoration-none">
                            <div class="border rounded p-4 text-center h-100 hover-shadow">
                                <div class="bg-light p-3 rounded-circle d-inline-flex mb-3">
                                    <i class="fas fa-chart-bar text-primary"></i>
                                </div>
                                <h6 class="mb-0">Reportes</h6>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-shadow {
    transition: all 0.3s ease;
}
.hover-shadow:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
}
</style>
