@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editForms = document.querySelectorAll('form[action*="usuarios/update"]');
        
        editForms.forEach(form => {
            form.addEventListener('submit', function(event) {
                let isValid = true;
                const name = form.querySelector('input[name="name"]');
                const email = form.querySelector('input[name="email"]');
                const password = form.querySelector('input[name="password"]');
                const passwordConfirmation = form.querySelector('input[name="password_confirmation"]');
                
                // Reset error messages
                form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                
                // Validate name
                if (!name.value.trim()) {
                    showError(name, 'El nombre es obligatorio');
                    isValid = false;
                }
                
                // Validate email
                if (!email.value.trim()) {
                    showError(email, 'El correo electrónico es obligatorio');
                    isValid = false;
                } else if (!/\S+@\S+\.\S+/.test(email.value)) {
                    showError(email, 'Por favor ingrese un correo electrónico válido');
                    isValid = false;
                }
                
                // Validate password only if provided
                if (password.value) {
                    if (password.value.length < 8) {
                        showError(password, 'La contraseña debe tener al menos 8 caracteres');
                        isValid = false;
                    }
                    
                    // Validate password confirmation if password is provided
                    if (password.value !== passwordConfirmation.value) {
                        showError(passwordConfirmation, 'Las contraseñas no coinciden');
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

<div class="modal fade" id="editUsuario{{ $usuario->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-warning">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h4 class="card-title">Editar Usuario
                            <small>&nbsp;(*) Campos requeridos</small>
                        </h4>
                        <button type="button" class="close d-sm-inline-block text-white" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}" id="editUserForm{{ $usuario->id }}" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Nombre(*)</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $usuario->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="email">Email(*)</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $usuario->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="rol">Rol(*)</label>
                                        <select name="rol" class="form-control @error('rol') is-invalid @enderror" required>
                                            @error('rol')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <option value="">Seleccione un rol</option>
                                            <option value="Administrador" {{ (isset($usuario) && $usuario->rol == 'administrador') ? 'selected' : '' }}>Administrador
                                            </option>
                                            <option value="Profesor" {{ (isset($usuario) && $usuario->rol == 'profesor') ? 'selected' : '' }}>Profesor</option>
                                            <option value="Cliente" {{ (isset($usuario) && $usuario->rol == 'cliente') ? 'selected' : '' }}>Cliente</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="password">Nueva Contraseña</label>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" minlength="8">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Dejar en blanco para no cambiar la contraseña.</small>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
                                        @error('password_confirmation')
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