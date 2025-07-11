@extends('adminlte::page')

@section('title', ' | Dashboard')

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
    .progress {
        height: 6px;
        border-radius: 3px;
        background: #E0E0E0;
    }
    .progress-bar {
        background: #1976D2;
    }
    .list-group-item {
        border: none;
        padding: 12px 0;
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
            <h3 class="form-title">Bienvenido de vuelta</h3>
            <p class="text-muted">Aquí está el resumen de tu actividad</p>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Tu Membresía</h5>
                        @if($membresia)
                            <div class="d-flex align-items-center mb-4">
                                <div class="icon-circle mr-3">
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
                                <div class="progress">
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
                                    <a href="{{ route('membresias.list') }}" class="btn btn-outline-primary">Ver Membresías Disponibles</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title mb-0">Próximas Clases</h5>
                            <a href="{{ route('clases.list') }}" class="small text-primary">Ver todas</a>
                        </div>
                        @if(count($clases) > 0)
                            <div class="list-group list-group-flush">
                                @foreach($clases as $clase)
                                    <div class="list-group-item">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle mr-3">
                                                <i class="fas fa-swimmer text-muted"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $clase->tipo }}</h6>
                                                <p class="mb-0 small text-muted">
                                                    {{ $clase->fecha->format('d M, H:i') }}
                                                    @if($clase->profesor)
                                                        • {{ $clase->profesor->name }} {{ $clase->profesor->last_name ?? '' }}
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
    </div>
@endsection