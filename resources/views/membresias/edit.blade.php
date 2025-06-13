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

                    <form method="POST" action="{{ route('membresias.update', $membresia->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="id_usuario">Usuario(*)</label>
                                                <select name="id_usuario" class="form-control" required>
                                                    <option value="" disabled>Seleccione un usuario</option>
                                                    @foreach ($usuarios as $usuario)
                                                        <option value="{{ $usuario->id }}"
                                                            {{ $usuario->id == $membresia->id_usuario ? 'selected' : '' }}>
                                                            {{ $usuario->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="clases_adquiridas">Clases Adquiridas(*)</label>
                                                <input type="number" name="clases_adquiridas" class="form-control" min="0"
                                                    value="{{ $membresia->clases_adquiridas }}" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="clases_disponibles">Clases Disponibles(*)</label>
                                                <input type="number" name="clases_disponibles" class="form-control" min="0"
                                                    value="{{ $membresia->clases_disponibles }}" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="clases_ocupadas">Clases Ocupadas(*)</label>
                                                <input type="number" name="clases_ocupadas" class="form-control" min="0"
                                                    value="{{ $membresia->clases_ocupadas }}" required>
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