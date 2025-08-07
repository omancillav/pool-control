@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set minimum date to today for all date inputs
        document.querySelectorAll('input[type="date"]').forEach(input => {
            input.min = new Date().toISOString().split('T')[0];
        });

        // Add event listeners to all class edit forms
        document.querySelectorAll('form[action*="clases/update"]').forEach(form => {
            // Auto-calculate available places when total or occupied changes
            const lugaresInput = form.querySelector('input[name="lugares"]');
            const ocupadosInput = form.querySelector('input[name="lugares_ocupados"]');
            const disponiblesInput = form.querySelector('input[name="lugares_disponibles"]');

            const calculateAvailablePlaces = () => {
                const lugares = parseInt(lugaresInput.value) || 0;
                const ocupados = parseInt(ocupadosInput.value) || 0;
                const disponibles = lugares - ocupados;
                disponiblesInput.value = disponibles > 0 ? disponibles : 0;
            };

            if (lugaresInput && ocupadosInput && disponiblesInput) {
                lugaresInput.addEventListener('input', calculateAvailablePlaces);
                ocupadosInput.addEventListener('input', calculateAvailablePlaces);

                // Initial calculation
                calculateAvailablePlaces();
            }

            // Form submission validation
            form.addEventListener('submit', function(event) {
                let isValid = true;

                // Reset error messages
                form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

                // Validate date is not in the past
                const fechaInput = form.querySelector('input[name="fecha"]');
                if (fechaInput) {
                    const selectedDate = new Date(fechaInput.value);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);

                    if (selectedDate < today) {
                        showError(fechaInput, 'La fecha no puede ser anterior al día de hoy');
                        isValid = false;
                    }
                }

                // Validate that occupied places don't exceed total places
                if (lugaresInput && ocupadosInput) {
                    const lugares = parseInt(lugaresInput.value) || 0;
                    const lugaresOcupados = parseInt(ocupadosInput.value) || 0;

                    if (lugaresOcupados > lugares) {
                        showError(ocupadosInput, 'Los lugares ocupados no pueden ser más que los lugares totales');
                        isValid = false;
                    }

                    const lugaresDisponibles = lugares - lugaresOcupados;
                    if (disponiblesInput && parseInt(disponiblesInput.value) !== lugaresDisponibles) {
                        showError(disponiblesInput, 'Los lugares disponibles deben ser igual a (Lugares Totales - Lugares Ocupados)');
                        isValid = false;
                    }
                }

                if (!isValid) {
                    event.preventDefault();
                    event.stopPropagation();
                }
            });
        });

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

<style>
    .modal-content {
        border-radius: 16px;
        border: 1px solid #E0E0E0;
        box-shadow: 0 2px 8px rgba(176,190,197,0.12);
        background: #fff;
    }
    .modal-header {
        position: relative;
        background: linear-gradient(90deg, #E6F0FA 0%, #B3D4FC 100%);
        border-radius: 16px 16px 0 0;
        border-bottom: none;
        padding: 16px 24px;
    }
    .modal-title {
        font-size: 1.8rem;
        font-weight: bold;
        color: #222;
    }
    .modal-title small {
        font-size: 0.9rem;
        font-weight: normal;
        color: #555;
    }
    .close {
        color: #222;
        opacity: 0.8;
        font-size: 1.5rem;
        text-shadow: none;
    }
    .close:hover {
        opacity: 1;
    }
    .modal-body {
        background: #fff;
        padding: 24px;
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
    .form-group small.text-muted {
        font-size: 0.85rem;
    }
    .modal-footer {
        border-top: none;
        padding: 16px 24px;
        background: #fff;
        border-radius: 0 0 16px 16px;
    }
    .btn-close {
        background: #B3D4FC;
        border: 1px solid #B3D4FC;
        color: #222;
        border-radius: 6px;
        font-weight: bold;
        padding: 8px 16px;
    }
    .btn-save {
        background: #1976D2;
        border: 1px solid #1976D2;
        color: #fff;
        border-radius: 6px;
        font-weight: bold;
        padding: 8px 16px;
    }
</style>

@foreach ($clases as $clase)
    <div class="modal fade" id="editClase{{ $clase->id }}" tabindex="-1" role="dialog"
        aria-labelledby="editClaseModalLabel{{ $clase->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editClaseModalLabel{{ $clase->id }}">Editar Clase
                        <small>(* Campos requeridos)</small>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form method="POST" action="{{ route('clases.update', $clase->id) }}" id="editClaseForm{{ $clase->id }}" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="fecha{{ $clase->id }}">Fecha (*)</label>
                                    <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror"
                                        id="fecha{{ $clase->id }}"
                                        value="{{ old('fecha', $clase->fecha->format('Y-m-d')) }}"
                                        required
                                        aria-describedby="fecha-error{{ $clase->id }}"
                                        title="Seleccione una fecha">
                                    @error('fecha')
                                    <div class="invalid-feedback" id="fecha-error{{ $clase->id }}">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="id_profesor{{ $clase->id }}">Profesor (*)</label>
                                    <select name="id_profesor" class="form-control @error('id_profesor') is-invalid @enderror"
                                        id="id_profesor{{ $clase->id }}" required
                                        aria-describedby="id_profesor-error{{ $clase->id }}"
                                        title="Seleccione un profesor">
                                        <option value="" disabled>Seleccione un profesor</option>
                                        @foreach ($profesores as $profesor)
                                        @if($profesor->rol === 'Profesor')
                                        <option value="{{ $profesor->id }}" {{ old('id_profesor', $clase->id_profesor) == $profesor->id ? 'selected' : '' }}>
                                            {{ $profesor->name }} {{ $profesor->last_name ?? '' }}
                                        </option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @error('id_profesor')
                                    <div class="invalid-feedback" id="id_profesor-error{{ $clase->id }}">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="nivel{{ $clase->id }}">Nivel (*)</label>
                                    <select name="nivel" class="form-control @error('nivel') is-invalid @enderror"
                                        id="nivel{{ $clase->id }}"
                                        required
                                        aria-describedby="nivel-error{{ $clase->id }}"
                                        title="Seleccione el nivel de la clase">
                                        <option value="">Seleccionar nivel</option>
                                        <option value="Principiante" {{ old('nivel', $clase->nivel) == 'Principiante' ? 'selected' : '' }}>Principiante</option>
                                        <option value="Intermedio" {{ old('nivel', $clase->nivel) == 'Intermedio' ? 'selected' : '' }}>Intermedio</option>
                                        <option value="Avanzado" {{ old('nivel', $clase->nivel) == 'Avanzado' ? 'selected' : '' }}>Avanzado</option>
                                        <option value="Competencia" {{ old('nivel', $clase->nivel) == 'Competencia' ? 'selected' : '' }}>Competencia</option>
                                        <option value="Terapéutico" {{ old('nivel', $clase->nivel) == 'Terapéutico' ? 'selected' : '' }}>Terapéutico</option>
                                        <option value="Infantil" {{ old('nivel', $clase->nivel) == 'Infantil' ? 'selected' : '' }}>Infantil</option>
                                    </select>
                                    @error('nivel')
                                    <div class="invalid-feedback" id="nivel-error{{ $clase->id }}">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="lugares{{ $clase->id }}">Lugares Totales (*)</label>
                                    <input type="number" name="lugares" min="1" class="form-control @error('lugares') is-invalid @enderror"
                                        id="lugares{{ $clase->id }}"
                                        value="{{ old('lugares', $clase->lugares) }}"
                                        required
                                        aria-describedby="lugares-error{{ $clase->id }}"
                                        title="Ingrese el número total de lugares">
                                    @error('lugares')
                                    <div class="invalid-feedback" id="lugares-error{{ $clase->id }}">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="lugares_ocupados{{ $clase->id }}">Lugares Ocupados (*)</label>
                                    <input type="number" name="lugares_ocupados" min="0"
                                        class="form-control @error('lugares_ocupados') is-invalid @enderror"
                                        id="lugares_ocupados{{ $clase->id }}"
                                        value="{{ old('lugares_ocupados', $clase->lugares_ocupados) }}"
                                        required
                                        aria-describedby="lugares_ocupados-error{{ $clase->id }}"
                                        title="Ingrese el número de lugares ocupados">
                                    @error('lugares_ocupados')
                                    <div class="invalid-feedback" id="lugares_ocupados-error{{ $clase->id }}">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="lugares_disponibles{{ $clase->id }}">Lugares Disponibles (*)</label>
                                    <input type="number" name="lugares_disponibles" min="0"
                                        class="form-control @error('lugares_disponibles') is-invalid @enderror"
                                        id="lugares_disponibles{{ $clase->id }}"
                                        value="{{ old('lugares_disponibles', $clase->lugares_disponibles) }}"
                                        required
                                        readonly
                                        aria-describedby="lugares_disponibles-error{{ $clase->id }}"
                                        title="Lugares disponibles (calculado automáticamente)">
                                    @error('lugares_disponibles')
                                    <div class="invalid-feedback" id="lugares_disponibles-error{{ $clase->id }}">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-close" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-save">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach