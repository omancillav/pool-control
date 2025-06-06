@extends('adminlte::page')

@section('title', ' | Membresías')

@section('content')
<section class="content">
    <div class="right_col" role="main">
        <div class="col-md-12 col-sm-12">
            <div class="x_panel">
                <div class="x_title d-flex justify-content-between align-items-center">
                    <h2>Membresías</h2>
                    <form method="GET" action="{{ route('membresias.list') }}" class="form-inline">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Buscar..."
                                value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <table id="membresias" class="table table-striped display responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>ID Usuario</th>
                                            <th>Clases Adquiridas</th>
                                            <th>Clases Disponibles</th>
                                            <th>Clases Ocupadas</th>
                                            <th>Creado el</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($membresias as $membresia)
                                            <tr>
                                                <td>{{ $membresia->id }}</td>
                                                <td>{{ $membresia->id_usuario }}</td>
                                                <td>{{ $membresia->clases_adquiridas }}</td>
                                                <td>{{ $membresia->clases_disponibles }}</td>
                                                <td>{{ $membresia->clases_ocupadas }}</td>
                                                <td>{{ $membresia->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Opciones">
                                                        <!-- Aquí puedes agregar botones de acción si quieres -->
                                                        <button type="button" class="btn btn-info" title="Ver">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-warning" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger" title="Eliminar">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No se encontraron resultados.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center mt-3">
                                    {!! $membresias->links('pagination::bootstrap-4') !!}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#membresias').DataTable({
            responsive: true,
            paging: false,
            info: false,
            searching: false,
            order: [[0, 'desc']],  // Ordenar por ID descendente
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Reporte de Membresías'
                },
                {
                    extend: 'csvHtml5',
                    title: 'Reporte de Membresías'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Reporte de Membresías'
                },
                {
                    extend: 'print',
                    title: 'Reporte de Membresías'
                }
            ]
        });

        var successMessage = "{{ session('success') }}";
        var errorMessage = "{{ session('error') }}";

        if (successMessage) {
            Swal.fire({
                title: 'Éxito',
                text: successMessage,
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
        }

        if (errorMessage) {
            Swal.fire({
                title: 'Error',
                text: errorMessage,
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    });
</script>
@endsection