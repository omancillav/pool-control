<style>
    .modal-content {
        border-radius: 16px;
        border: 1px solid #E0E0E0;
        box-shadow: 0 2px 8px rgba(176,190,197,0.12);
        background: #fff;
    }
    .modal-header {
        position: relative;
        background: linear-gradient(90deg, #F8D7DA 0%, #F5C6CB 100%); /* Gradiente rojo suave para eliminación */
        border-radius: 16px 16px 0 0;
        border-bottom: none;
        padding: 16px 24px;
    }
    .modal-title {
        font-size: 1.8rem;
        font-weight: bold;
        color: #222;
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
        text-align: center;
        color: #721C24; /* Color rojo oscuro para el texto */
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
    .btn-delete {
        background: #DC3545; /* Rojo para eliminación */
        border: 1px solid #DC3545;
        color: #fff;
        border-radius: 6px;
        font-weight: bold;
        padding: 8px 16px;
    }
</style>

@foreach ($usuarios as $usuario)
    <div class="modal fade" id="delete{{ $usuario->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $usuario->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteModalLabel{{ $usuario->id }}">Eliminar Usuario</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>¿Estás seguro de eliminar al usuario <strong>{{ $usuario->name }} {{ $usuario->last_name ?? '' }}</strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-close" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-delete">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach