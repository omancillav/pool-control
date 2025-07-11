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

<div class="modal fade" id="editUsuario{{ $usuario->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editUsuarioModalLabel{{ $usuario->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editUsuarioModalLabel{{ $usuario->id }}">Editar Usuario
                    <small>(* Campos requeridos)</small>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}" id="editUserForm{{ $usuario->id }}" novalidate>
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name{{ $usuario->id }}">Nombre(*)</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name{{ $usuario->id }}"
                                    value="{{ old('name', $usuario->name) }}" required aria-describedby="name-error{{ $usuario->id }}">
                                @error('name')
                                    <div class="invalid-feedback" id="name-error{{ $usuario->id }}">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email{{ $usuario->id }}">Email(*)</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email{{ $usuario->id }}"
                                    value="{{ old('email', $usuario->email) }}" required aria-describedby="email-error{{ $usuario->id }}">
                                @error('email')
                                    <div class="invalid-feedback" id="email-error{{ $usuario->id }}">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="rol{{ $usuario->id }}">Rol(*)</label>
                                <select name="rol" class="form-control @error('rol') is-invalid @enderror" id="rol{{ $usuario->id }}" required
                                    aria-describedby="rol-error{{ $usuario->id }}">
                                    <option value="">Seleccione un rol</option>
                                    <option value="Administrador" {{ old('rol', $usuario->rol) == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                                    <option value="Profesor" {{ old('rol', $usuario->rol) == 'Profesor' ? 'selected' : '' }}>Profesor</option>
                                    <option value="Cliente" {{ old('rol', $usuario->rol) == 'Cliente' ? 'selected' : '' }}>Cliente</option>
                                </select>
                                @error('rol')
                                    <div class="invalid-feedback" id="rol-error{{ $usuario->id }}">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="password{{ $usuario->id }}">Nueva Contraseña</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password{{ $usuario->id }}"
                                    minlength="8" aria-describedby="password-error{{ $usuario->id }}">
                                @error('password')
                                    <div class="invalid-feedback" id="password-error{{ $usuario->id }}">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Dejar en blanco para no cambiar la contraseña.</small>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="password_confirmation{{ $usuario->id }}">Confirmar Nueva Contraseña</label>
                                <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror"
                                    id="password_confirmation{{ $usuario->id }}" aria-describedby="password-confirmation-error{{ $usuario->id }}">
                                @error('password_confirmation')
                                    <div class="invalid-feedback" id="password-confirmation-error{{ $usuario->id }}">{{ $message }}</div>
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