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

                <form method="POST" action="{{ route('clases.update', $clase->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="fecha">Fecha (*)</label>
                                        <input type="date" name="fecha" class="form-control" value="{{ $clase->fecha->format('Y-m-d') }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label for="id_profesor">Profesor (*)</label>
                                        <select name="id_profesor" class="form-control" required>
                                            <option value="" disabled>Seleccione un profesor</option>
                                            @foreach ($profesores as $profesor)
                                                <option value="{{ $profesor->id }}" {{ $clase->id_profesor == $profesor->id ? 'selected' : '' }}>
                                                    {{ $profesor->name }} {{ $profesor->last_name ?? '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="tipo">Tipo (*)</label>
                                        <input type="text" name="tipo" class="form-control" value="{{ $clase->tipo }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="lugares">Lugares Totales (*)</label>
                                        <input type="number" name="lugares" min="0" class="form-control" value="{{ $clase->lugares }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="lugares_ocupados">Lugares Ocupados (*)</label>
                                        <input type="number" name="lugares_ocupados" min="0" class="form-control" value="{{ $clase->lugares_ocupados }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="lugares_disponibles">Lugares Disponibles (*)</label>
                                        <input type="number" name="lugares_disponibles" min="0" class="form-control" value="{{ $clase->lugares_disponibles }}" required>
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