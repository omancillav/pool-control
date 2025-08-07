@extends('adminlte::page')

@section('title', 'Nueva Clase')

@section('css')
<link rel="stylesheet" href="{{ asset('css/panel.css') }}">
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

@section('content')
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
        <path d="M0,60 C360,70 1080,50 1440,60 L1440,70 L0,70 Z" fill="#f4f6f9" />
    </svg>
</div>
<div class="main-content">
    <div class="content-header">
        <h3 class="page-title">Registrar Nueva Clase</h3>
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

            <!-- Nivel -->
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="nivel">Nivel (*)</label>
                    <select class="form-control @error('nivel') is-invalid @enderror"
                        id="nivel" name="nivel"
                        required
                        aria-describedby="nivel-error"
                        title="Seleccione el nivel de la clase de natación">
                        <option value="">Seleccionar nivel</option>
                        <option value="Principiante" {{ old('nivel') == 'Principiante' ? 'selected' : '' }}>Principiante</option>
                        <option value="Intermedio" {{ old('nivel') == 'Intermedio' ? 'selected' : '' }}>Intermedio</option>
                        <option value="Avanzado" {{ old('nivel') == 'Avanzado' ? 'selected' : '' }}>Avanzado</option>
                        <option value="Competencia" {{ old('nivel') == 'Competencia' ? 'selected' : '' }}>Competencia</option>
                        <option value="Terapéutico" {{ old('nivel') == 'Terapéutico' ? 'selected' : '' }}>Terapéutico</option>
                        <option value="Infantil" {{ old('nivel') == 'Infantil' ? 'selected' : '' }}>Infantil</option>
                    </select>
                    @error('nivel')
                    <div class="invalid-feedback" id="nivel-error">{{ $message }}</div>
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
            <button type="submit" class="btn btn-primary">Registrar Clase</button>
        </div>
    </form>
</div>
@endsection