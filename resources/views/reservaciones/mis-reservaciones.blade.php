@extends('adminlte::page')

@section('title', 'Mis Reservaciones')

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
<div class="main-content">
  <div class="content-header">
    <h3 class="page-title">Mis Reservaciones</h3>

  </div>

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif

  @if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif

  <div class="row">
    <div class="col-lg-4">
      <form method="GET" action="{{ route('reservaciones.mis-reservaciones') }}" class="my-3">
        <div class="input-group">
          <input type="text" name="search" class="form-control" placeholder="Buscar por nivel de clase o profesor..."
            value="{{ request('search') }}" aria-describedby="search-button">
          <div class="input-group-append">
            <button type="submit" class="btn btn-search" id="search-button">Buscar</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-striped display responsive nowrap" style="width:100%">
      <thead>
        <tr>
          <th>Fecha Clase</th>
          <th>Nivel</th>
          <th>Profesor</th>
          <th>Fecha Reservación</th>
          <th>Notas</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($reservaciones as $reservacion)
        <tr>
          <td>{{ \Carbon\Carbon::parse($reservacion->clase->fecha)->format('d/m/Y') }}</td>
          <td>{{ $reservacion->clase->nivel }}</td>
          <td>{{ $reservacion->clase->profesor->name }}</td>
          <td>{{ $reservacion->created_at->format('d/m/Y H:i') }}</td>
          <td>
            @if($reservacion->notas)
            <span class="text-truncate" style="max-width: 150px; display: inline-block;"
              title="{{ $reservacion->notas }}">
              {{ $reservacion->notas }}
            </span>
            @else
            <span class="text-muted">Sin notas</span>
            @endif
          </td>
          <td>
            @if($reservacion->clase->fecha >= now()->toDateString())
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
              data-target="#cancelarModal{{ $reservacion->id }}">
              <i class="fas fa-times"></i> Cancelar
            </button>
            @else
            <span class="text-muted">Clase finalizada</span>
            @endif
          </td>
        </tr>

        <!-- Modal para cancelar -->
        @if($reservacion->clase->fecha >= now()->toDateString())
        <div class="modal fade" id="cancelarModal{{ $reservacion->id }}" tabindex="-1" role="dialog"
          aria-labelledby="cancelarModalLabel{{ $reservacion->id }}" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="cancelarModalLabel{{ $reservacion->id }}">
                  Cancelar Reservación
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>¿Estás seguro de que quieres cancelar tu reservación para:</p>
                <ul>
                  <li><strong>Nivel:</strong> {{ $reservacion->clase->nivel }}</li>
                  <li><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($reservacion->clase->fecha)->format('d/m/Y') }}</li>
                  <li><strong>Profesor:</strong> {{ $reservacion->clase->profesor->name }}</li>
                </ul>
                <p class="text-warning"><strong>Nota:</strong> Esta acción no se puede deshacer.</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No, mantener reservación</button>
                <form action="{{ route('reservaciones.cancelar', $reservacion->id) }}" method="POST" style="display: inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">Sí, cancelar reservación</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        @endif
        @empty
        <tr>
          <td colspan="6" class="text-center">
            No tienes reservaciones.
            <a href="{{ route('reservaciones.index') }}">¡Haz tu primera reservación!</a>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="d-flex justify-content-center">
    {{ $reservaciones->appends(request()->query())->links() }}
  </div>
</div>
@endsection