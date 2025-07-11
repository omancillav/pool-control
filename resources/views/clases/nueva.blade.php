@extends('adminlte::page')

@section('title', 'Nueva Clase')

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
        background: linear-gradient(90deg, #E6F0FA 0%, #B3D4FC 100%); /* Gradiente azul consistente */
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
    .form-control {
        border-radius: 6px;
        border: 1px solid #E0E0E0;
        box-shadow: 0 2px 4px rgba(176,190,197,0.1);
    }
    .form-group label {
        font-weight: bold;
        color: #222;
    }
    .btn-submit {
        background: #1976D2; /* Azul consistente con membresías */
        border: 1px solid #1976D2;
        color: #fff;
        border-radius: 6px;
        font-weight: bold;
        padding: 8px 16px;
    }
</style>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const fechaInput = document.getElementById('fecha');

        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        fechaInput.min = today;

        form.addEventListener('submit', function(event) {
            let isValid = true;

            // Reset error messages
            form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

            // Validate date is not in the past
            const selectedDate = new Date(fechaInput.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            if (selectedDate < today) {
                showError(fechaInput, 'La fecha no puede ser anterior al día de hoy');
                isValid = false;
            }

            // Validate that occupied places don't exceed total places
            const lugares = parseInt(document.getElementById('lugares').value) || 0;
            const lugaresOcupados = parseInt(document.getElementById('lugares_ocupados').value) || 0;
            const lugaresDisponibles = parseInt(document.getElementById('lugares_disponibles').value) || 0;

            if (lugaresOcupados > lugares) {
                showError(document.getElementById('lugares_ocupados'), 'Los lugares ocupados no pueden ser más que los lugares totales');
                isValid = false;
            }

            if (lugaresDisponibles !== (lugares - lugaresOcupados)) {
                showError(document.getElementById('lugares_disponibles'), 'Los lugares disponibles deben ser igual a (Lugares Totales - Lugares Ocupados)');
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault();
            }
        });

        // Auto-calculate available places when total or occupied changes
        document.getElementById('lugares').addEventListener('input', calculateAvailablePlaces);
        document.getElementById('lugares_ocupados').addEventListener('input', calculateAvailablePlaces);

        function calculateAvailablePlaces() {
            const lugares = parseInt(document.getElementById('lugares').value) || 0;
            const ocupados = parseInt(document.getElementById('lugares_ocupados').value) || 0;
            const disponibles = lugares - ocupados;
            document.getElementById('lugares_disponibles').value = disponibles > 0 ? disponibles : 0;
        }

        function showError(input, message) {
            input.classList.add('is-invalid');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback';
            errorDiv.textContent = message;
            input.parentNode.appendChild(errorDiv);
        }
    });
</script>
@endpush

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
            <h3 class="form-title">Registrar Nueva Clase</h3>
        </div>
        <form action="{{ route('clases.store') }}" method="POST" id="claseForm" novalidate>
            @csrf
            <div class="row">
                <!-- Fecha -->
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="fecha">Fecha (*)</label>
                        <input type="date" class="form-control @error('fecha') is-invalid @enderror"
                            id="fecha" name="fecha"
                            value="{{ old('fecha') }}" required
                            aria-describedby="fecha-error"
                            title="Seleccione una fecha">
                        @error('fecha')
                        <div class="invalid-feedback" id="fecha-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Profesor -->
                <div class="col-lg-8">
                    <div class="form-group">
                        <label for="id_profesor">Profesor (*)</label>
                        <select class="form-control @error('id_profesor') is-invalid @enderror"
                            id="id_profesor" name="id_profesor" required
                            aria-describedby="id_profesor-error"
                            title="Seleccione un profesor">
                            <option value="" disabled selected>Seleccione un profesor</option>
                            @foreach ($profesores as $profesor)
                            @if($profesor->rol === 'Profesor')
                            <option value="{{ $profesor->id }}" {{ old('id_profesor') == $profesor->id ? 'selected' : '' }}>
                                {{ $profesor->name }} {{ $profesor->last_name ?? '' }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                        @error('id_profesor')
                        <div class="invalid-feedback" id="id_profesor-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Tipo -->
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="tipo">Tipo (*)</label>
                        <input type="text" class="form-control @error('tipo') is-invalid @enderror"
                            id="tipo" name="tipo"
                            value="{{ old('tipo') }}"
                            placeholder="Ej: Presencial, Virtual"
                            required
                            aria-describedby="tipo-error"
                            title="Ingrese el tipo de clase">
                        @error('tipo')
                        <div class="invalid-feedback" id="tipo-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Lugares -->
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="lugares">Lugares Totales (*)</label>
                        <input type="number" class="form-control @error('lugares') is-invalid @enderror"
                            id="lugares" name="lugares"
                            value="{{ old('lugares') }}"
                            min="1"
                            required
                            aria-describedby="lugares-error"
                            title="Ingrese el número total de lugares">
                        @error('lugares')
                        <div class="invalid-feedback" id="lugares-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Lugares Ocupados -->
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="lugares_ocupados">Lugares Ocupados (*)</label>
                        <input type="number" class="form-control @error('lugares_ocupados') is-invalid @enderror"
                            id="lugares_ocupados" name="lugares_ocupados"
                            value="{{ old('lugares_ocupados', 0) }}"
                            min="0"
                            required
                            aria-describedby="lugares_ocupados-error"
                            title="Ingrese el número de lugares ocupados">
                        @error('lugares_ocupados')
                        <div class="invalid-feedback" id="lugares_ocupados-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Lugares Disponibles -->
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="lugares_disponibles">Lugares Disponibles (*)</label>
                        <input type="number" class="form-control @error('lugares_disponibles') is-invalid @enderror"
                            id="lugares_disponibles" name="lugares_disponibles"
                            value="{{ old('lugares_disponibles') }}"
                            min="0"
                            required
                            readonly
                            aria-describedby="lugares_disponibles-error"
                            title="Lugares disponibles (calculado automáticamente)">
                        @error('lugares_disponibles')
                        <div class="invalid-feedback" id="lugares_disponibles-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer bg-white border-0" style="text-align:right;">
                <button type="submit" class="btn btn-submit">Registrar Clase</button>
            </div>
        </form>
    </div>
@endsection