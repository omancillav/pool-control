@extends('adminlte::page')

@section('title', 'Nueva Clase')

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
<h1>Registrar Nueva Clase</h1>
@endsection

@section('content')
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Registrar Nueva Clase</h3>
    </div>
    <form action="{{ route('clases.store') }}" method="POST" id="claseForm" novalidate>
        @csrf
        <div class="card-body">
            <div class="row">
                <!-- Fecha -->
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="fecha">Fecha (*)</label>
                        <input type="date" class="form-control @error('fecha') is-invalid @enderror"
                            id="fecha" name="fecha"
                            value="{{ old('fecha') }}" required
                            title="Seleccione una fecha">
                        @error('fecha')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Profesor -->
                <div class="col-lg-8">
                    <div class="form-group">
                        <label for="id_profesor">Profesor (*)</label>
                        <select class="form-control @error('id_profesor') is-invalid @enderror"
                            id="id_profesor" name="id_profesor" required
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
                        <div class="invalid-feedback">{{ $message }}</div>
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
                            title="Ingrese el tipo de clase">
                        @error('tipo')
                        <div class="invalid-feedback">{{ $message }}</div>
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
                            title="Ingrese el número total de lugares">
                        @error('lugares')
                        <div class="invalid-feedback">{{ $message }}</div>
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
                            title="Ingrese el número de lugares ocupados">
                        @error('lugares_ocupados')
                        <div class="invalid-feedback">{{ $message }}</div>
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
                            title="Lugares disponibles (calculado automáticamente)">
                        @error('lugares_disponibles')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success float-right">Registrar Clase</button>
        </div>
    </form>
</div>
@endsection

@section('css')
{{-- Estilos personalizados opcionales --}}
@endsection

@section('js')
{{-- Scripts personalizados opcionales --}}
@endsection