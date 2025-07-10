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

<div class="modal fade" id="editClase{{ $clase->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editClaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-warning">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h4 class="card-title">Editar Clase
                            <small>&nbsp;(*) Campos requeridos</small>
                        </h4>
                        <button type="button" class="close d-sm-inline-block text-white" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                <form method="POST" action="{{ route('clases.update', $clase->id) }}" id="editClaseForm{{ $clase->id }}" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="fecha">Fecha (*)</label>
                                        <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror"
                                            value="{{ old('fecha', $clase->fecha->format('Y-m-d')) }}"
                                            required
                                            title="Seleccione una fecha">
                                        @error('fecha')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label for="id_profesor">Profesor (*)</label>
                                        <select name="id_profesor" class="form-control @error('id_profesor') is-invalid @enderror"
                                            required
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
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="tipo">Tipo (*)</label>
                                        <input type="text" name="tipo" class="form-control @error('tipo') is-invalid @enderror"
                                            value="{{ old('tipo', $clase->tipo) }}"
                                            required
                                            title="Ingrese el tipo de clase">
                                        @error('tipo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="lugares">Lugares Totales (*)</label>
                                        <input type="number" name="lugares" min="1" class="form-control @error('lugares') is-invalid @enderror"
                                            value="{{ old('lugares', $clase->lugares) }}"
                                            required
                                            title="Ingrese el número total de lugares">
                                        @error('lugares')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="lugares_ocupados">Lugares Ocupados (*)</label>
                                        <input type="number" name="lugares_ocupados" min="0"
                                            class="form-control @error('lugares_ocupados') is-invalid @enderror"
                                            value="{{ old('lugares_ocupados', $clase->lugares_ocupados) }}"
                                            required
                                            title="Ingrese el número de lugares ocupados">
                                        @error('lugares_ocupados')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="lugares_disponibles">Lugares Disponibles (*)</label>
                                        <input type="number" name="lugares_disponibles" min="0"
                                            class="form-control @error('lugares_disponibles') is-invalid @enderror"
                                            value="{{ old('lugares_disponibles', $clase->lugares_disponibles) }}"
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
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-warning">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>