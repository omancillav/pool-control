@extends('adminlte::page')

@section('title', ' | Dashboard Profesor')

@section('css')
<style>
    body {
        background: #E6F0FA;
    }
    .header-wave {
        position: relative;
        background: linear-gradient(90deg, #E6F0FA 0%, #B3D4FC 100%);
        overflow: hidden;
        border-radius: 0 0 32px 32px;
        box-shadow: 0 2px 8px rgba(176,190,197,0.12);
        padding: 16px 24px;
    }
    .wave-svg {
        position: absolute;
        left: 0; right: 0; bottom: 0;
        width: 100%; height: 70px;
        z-index: 0;
    }
    .wibesand-logo {
        font-weight: bold;
        font-size: 2rem;
        color: #FFC107;
        letter-spacing: 2px;
        display: flex;
        align-items: center;
        z-index: 1;
        position: relative;
    }
    .wibesand-logo .logo-icon {
        width: 36px; height: 36px; margin-right: 10px;
        background: #1976D2;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
    }
    .main-content {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(176,190,197,0.12);
        padding: 32px 16px 24px 16px;
        margin-bottom: 28px;
        border: 1px solid #E0E0E0;
    }
    .form-header {
        background: linear-gradient(90deg, #E6F0FA 0%, #B3D4FC 100%);
        border-radius: 12px 12px 0 0;
        padding: 16px 24px;
        margin: -32px -16px 24px -16px;
        box-shadow: 0 2px 4px rgba(176,190,197,0.1);
    }
    .form-title {
        font-size: 1.8rem;
        font-weight: bold;
        color: #222;
        margin: 0;
    }
    .card {
        border-radius: 6px;
        border: 1px solid #E0E0E0;
        box-shadow: 0 2px 4px rgba(176,190,197,0.1);
        background: #fff;
    }
    .card-body {
        padding: 24px;
    }
    .card-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #222;
        margin-bottom: 16px;
    }
    .card-footer {
        background: #fff;
        border-top: none;
        padding: 16px 24px;
        border-radius: 0 0 6px 6px;
    }
    .icon-circle {
        background: #F8F9FA;
        padding: 12px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .text-muted {
        color: #555 !important;
    }
    .table {
        border-radius: 6px;
        border: 1px solid #E0E0E0;
        box-shadow: 0 2px 4px rgba(176,190,197,0.1);
        background: #fff;
    }
    .table thead th {
        font-weight: bold;
        color: #222;
        background: #F8F9FA;
        border: none;
    }
    .table tbody tr {
        border-bottom: 1px solid #E0E0E0;
    }
    .badge {
        font-size: 0.85rem;
        font-weight: bold;
        border-radius: 6px;
        border: 1px solid #E0E0E0;
        padding: 6px 12px;
    }
    .badge-success {
        background: #D4EDDA;
        color: #155724;
    }
    .badge-danger {
        background: #F8D7DA;
        color: #721C24;
    }
    .btn-primary {
        background: #1976D2;
        border: 1px solid #1976D2;
        color: #fff;
        border-radius: 6px;
        font-weight: bold;
        padding: 8px 16px;
    }
    .btn-outline-primary {
        border: 1px solid #1976D2;
        color: #1976D2;
        border-radius: 6px;
        font-weight: bold;
        padding: 8px 16px;
    }
    .btn-outline-primary:hover {
        background: #1976D2;
        color: #fff;
    }
    .text-primary {
        color: #1976D2 !important;
    }
</style>
@endsection

@section('content_header')
    <div class="header-wave">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div class="wibesand-logo">
                <span class="logo-icon">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Logo de Pool Control" style="width:32px; height:32px; border-radius:50%; object-fit:cover; background:#1976D2;" />
                </span>
                Pool Control
            </div>
            <div></div>
        </div>
        <svg class="wave-svg" viewBox="0 0 1440 70" preserveAspectRatio="none">
            <path d="M0,70 C360,30 1080,110 1440,70 L1440,70 L0,70 Z" fill="#fff"/>
        </svg>
    </div>
@endsection

@section('content')
    <div class="main-content">
        <div class="form-header">
            <h3 class="form-title">Bienvenido, Profesor</h3>
            <p class="text-muted">Aquí está tu calendario de clases</p>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
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
                                            <th>Fecha y Hora</th>
                                            <th>Tipo de Clase</th>
                                            <th class="text-center">Asistencia</th>
                                            <th class="text-right">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($clasesImpartidas as $clase)
                                            <tr>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon-circle mr-3">
                                                            <i class="fas fa-calendar-alt text-muted"></i>
                                                        </div>
                                                        <div>
                                                            <div class="font-weight-bold">{{ $clase->fecha->format('d M') }}</div>
                                                            <div class="text-muted small">{{ $clase->fecha->format('H:i') }}</div>
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
                                                            <span class="badge badge-success">
                                                                <i class="fas fa-circle mr-1"></i> Disponible
                                                            </span>
                                                        @else
                                                            <span class="badge badge-danger">
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
                            <div class="card-footer">
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
        </div>
    </div>
@endsection