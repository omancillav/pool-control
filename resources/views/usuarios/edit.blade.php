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

                <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Nombre(*)</label>
                                        <input type="text" name="name" class="form-control" value="{{ $usuario->name }}"
                                            required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="email">Email(*)</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ $usuario->email }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="rol">Rol(*)</label>
                                        <select name="rol" class="form-control" required>
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
                                        <input type="password" name="password" class="form-control">
                                        <small class="text-muted">Dejar en blanco para no cambiar la contraseña.</small>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                                        <input type="password" name="password_confirmation" class="form-control">
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