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

@foreach ($membresias as $membresia)
    <div class="modal fade" id="editMembresia{{ $membresia->id }}" tabindex="-1" role="dialog" aria-labelledby="editMembresiaModalLabel{{ $membresia->id }}"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editMembresiaModalLabel{{ $membresia->id }}">Editar Membresía
                        <small>(* Campos requeridos)</small>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form method="POST" action="{{ route('membresias.update', $membresia->id) }}" id="editMembresiaForm{{ $membresia->id }}" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="id_usuario{{ $membresia->id }}">Usuario(*)</label>
                                    <select name="id_usuario" class="form-control @error('id_usuario') is-invalid @enderror" id="id_usuario{{ $membresia->id }}" required 
                                        title="Por favor seleccione un cliente">
                                        <option value="" disabled>Seleccione un cliente</option>
                                        @foreach ($usuarios as $usuario)
                                            @if($usuario->rol === 'Cliente')
                                                <option value="{{ $usuario->id }}"
                                                    {{ old('id_usuario', $membresia->id_usuario) == $usuario->id ? 'selected' : '' }}>
                                                    {{ $usuario->name }} {{ $usuario->last_name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('id_usuario')
                                        <div class="invalid-feedback" id="id_usuario-error{{ $membresia->id }}">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="clases_adquiridas{{ $membresia->id }}">Clases Adquiridas(*)</label>
                                    <input type="number" name="clases_adquiridas" class="form-control @error('clases_adquiridas') is-invalid @enderror" 
                                        id="clases_adquiridas{{ $membresia->id }}" min="0"
                                        value="{{ old('clases_adquiridas', $membresia->clases_adquiridas) }}" required
                                        title="Ingrese el número de clases adquiridas">
                                    @error('clases_adquiridas')
                                        <div class="invalid-feedback" id="clases_adquiridas-error{{ $membresia->id }}">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="clases_disponibles{{ $membresia->id }}">Clases Disponibles(*)</label>
                                    <input type="number" name="clases_disponibles" class="form-control @error('clases_disponibles') is-invalid @enderror" 
                                        id="clases_disponibles{{ $membresia->id }}" min="0"
                                        value="{{ old('clases_disponibles', $membresia->clases_disponibles) }}" required
                                        title="Ingrese el número de clases disponibles">
                                    @error('clases_disponibles')
                                        <div class="invalid-feedback" id="clases_disponibles-error{{ $membresia->id }}">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="clases_ocupadas{{ $membresia->id }}">Clases Ocupadas(*)</label>
                                    <input type="number" name="clases_ocupadas" class="form-control @error('clases_ocupadas') is-invalid @enderror" 
                                        id="clases_ocupadas{{ $membresia->id }}" min="0"
                                        value="{{ old('clases_ocupadas', $membresia->clases_ocupadas) }}" required
                                        title="Ingrese el número de clases ocupadas">
                                    @error('clases_ocupadas')
                                        <div class="invalid-feedback" id="clases_ocupadas-error{{ $membresia->id }}">{{ $message }}</div>
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