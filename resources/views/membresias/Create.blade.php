<div class="modal fade" id="createMembresia" tabindex="-1" role="dialog" aria-labelledby="createMembresiaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-success">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h4 class="card-title">Registrar Membresía</h4>
                        <button type="button" class="close d-sm-inline-block" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <form action="{{ route('membresias.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-header py-2 bg-secondary">
                                <h3 class="card-title">Datos de la Membresía</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="id_usuario">Usuario(*)</label>
                                            <select class="form-control" id="id_usuario" name="id_usuario" required>
                                                <option value="" disabled selected>Seleccione un usuario</option>
                                                @foreach ($usuarios as $usuario)
                                                    <option value="{{ $usuario->id }}">{{ $usuario->name }} {{ $usuario->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="clases_adquiridas">Clases Adquiridas(*)</label>
                                            <input type="number" class="form-control" id="clases_adquiridas" name="clases_adquiridas" min="0" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="clases_disponibles">Clases Disponibles(*)</label>
                                            <input type="number" class="form-control" id="clases_disponibles" name="clases_disponibles" min="0" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="clases_ocupadas">Clases Ocupadas(*)</label>
                                            <input type="number" class="form-control" id="clases_ocupadas" name="clases_ocupadas" min="0" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>