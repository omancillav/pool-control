@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editForms = document.querySelectorAll('form[action*="membresias/update"]');
        
        editForms.forEach(form => {
            form.addEventListener('submit', function(event) {
                const clasesAdquiridas = form.querySelector('input[name="clases_adquiridas"]');
                const clasesDisponibles = form.querySelector('input[name="clases_disponibles"]');
                const clasesOcupadas = form.querySelector('input[name="clases_ocupadas"]');
                
                // Reset error messages
                form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                
                // Validate that available + occupied doesn't exceed acquired
                if (parseInt(clasesDisponibles.value) + parseInt(clasesOcupadas.value) > parseInt(clasesAdquiridas.value)) {
                    showError(clasesAdquiridas, 'La suma de clases disponibles y ocupadas no puede ser mayor a las clases adquiridas');
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

@foreach ($membresias as $membresia)
    <div class="modal fade" id="editMembresia{{ $membresia->id }}" tabindex="-1" role="dialog" aria-labelledby="editMembresiaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="card-warning">
                    <div class="card-header">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h4 class="card-title">Editar Membresía
                                <small>&nbsp;(*) Campos requeridos</small>
                            </h4>
                            <button type="button" class="close d-sm-inline-block text-white" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('membresias.update', $membresia->id) }}" id="editMembresiaForm{{ $membresia->id }}" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="id_usuario">Usuario(*)</label>
                                                <select name="id_usuario" class="form-control @error('id_usuario') is-invalid @enderror" required 
                                                        title="Por favor seleccione un cliente">
                                                        <option value="" disabled>Seleccione un cliente</option>
                                                        @foreach ($usuarios as $usuario)
                                                            @if($usuario->rol === 'Cliente')
                                                                <option value="{{ $usuario->id }}"
                                                                    {{ old('id_usuario', $usuario->id == $membresia->id_usuario ? 'selected' : '') }}>
                                                                    {{ $usuario->name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @error('id_usuario')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="clases_adquiridas">Clases Adquiridas(*)</label>
                                                <input type="number" name="clases_adquiridas" class="form-control @error('clases_adquiridas') is-invalid @enderror" min="0"
                                                    value="{{ old('clases_adquiridas', $membresia->clases_adquiridas) }}" required
                                                    title="Ingrese el número de clases adquiridas">
                                                @error('clases_adquiridas')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="clases_disponibles">Clases Disponibles(*)</label>
                                                <input type="number" name="clases_disponibles" class="form-control @error('clases_disponibles') is-invalid @enderror" min="0"
                                                    value="{{ old('clases_disponibles', $membresia->clases_disponibles) }}" required
                                                    title="Ingrese el número de clases disponibles">
                                                @error('clases_disponibles')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="clases_ocupadas">Clases Ocupadas(*)</label>
                                                <input type="number" name="clases_ocupadas" class="form-control @error('clases_ocupadas') is-invalid @enderror" min="0"
                                                    value="{{ old('clases_ocupadas', $membresia->clases_ocupadas) }}" required
                                                    title="Ingrese el número de clases ocupadas">
                                                @error('clases_ocupadas')
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
@endforeach 