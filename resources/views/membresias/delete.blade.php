<div class="modal fade" id="delete{{ $membresia->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $membresia->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="deleteModalLabel{{ $membresia->id }}">Eliminar Membresía</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('membresias.destroy', $membresia->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center text-danger">
                    <p>¿Estás seguro de eliminar la membresía del usuario <strong>{{ $membresia->usuario->name ?? 'Sin nombre' }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>