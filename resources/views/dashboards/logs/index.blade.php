@extends('adminlte::page')

@section('title', ' | Registro de Actividad')

@section('css')
<link rel="stylesheet" href="{{ asset('css/panel.css') }}">
@endsection

@section('content')
<div class="header-wave">
    <div style="display: flex; align-items: center; justify-content: space-between;">
        <div class="wibesand-logo">
            <span class="logo-icon">
                <img src="{{ asset('img/logo.jpg') }}" alt="Logo de Pool Control" style="width:32px; height:32px; border-radius:50%; object-fit:cover; background:#1976D2;" />
            </span>
            Pool Control
        </div>
        <div></div>
    </div>
    <svg class="wave-svg" viewBox="0 0 1440 70" preserveAspectRatio="none">
        <path d="M0,60 C360,70 1080,50 1440,60 L1440,70 L0,70 Z" fill="#f4f6f9" />
    </svg>
</div>

<section class="content main-content">
    <div class="right_col" role="main">
        <div class="col-md-12 col-sm-12">
            <div class="content-header">
                <h2 class="page-title">Registro de Actividad</h2>
            </div>

            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <table id="logs-table" class="table table-striped display responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Entidad</th>
                                        <th>Usuario</th>
                                        <th>Fecha y Hora</th>
                                        <th>Detalles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($activities as $activity)
                                    <tr>
                                        <td>{{ $activity->description }}</td>
                                        <td>{{ $activity->log_name }}</td>
                                        <td>{{ $activity->causer ? $activity->causer->name : 'Sistema' }}</td>
                                        <td>{{ $activity->created_at->format('d/m/Y H:i:s') }}</td>
                                        <td>
                                            @if($activity->properties->count() > 0 && (isset($activity->properties['attributes']) || isset($activity->properties['old'])))
                                                <button class="btn btn-info btn-sm" type="button" data-toggle="collapse" data-target="#collapse-{{ $activity->id }}" aria-expanded="false" aria-controls="collapse-{{ $activity->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <div class="collapse mt-2" id="collapse-{{ $activity->id }}">
                                                    <pre class="bg-light p-2 rounded"><code>{{ json_encode($activity->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                                                </div>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No hay actividades registradas.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center mt-3">
                                {!! $activities->links('pagination::bootstrap-4') !!}
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
        $('#logs-table').DataTable({
            responsive: true,
            paging: false,
            info: false,
            searching: false,
            ordering: false,
            dom: 'Bfrtip',
        });
    });
</script>
@endsection
