@extends('adminlte::page')

@section('title', 'Reservar Clases')

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
    <h3 class="page-title">Clases Disponibles para Reservar</h3>
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
      <form method="GET" action="{{ route('reservaciones.index') }}" class="my-3">
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
          <th>Fecha</th>
          <th>Nivel</th>
          <th>Profesor</th>
          <th>Lugares Disponibles</th>
          <th>Total Lugares</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($clases as $clase)
        <tr>
          <td>{{ \Carbon\Carbon::parse($clase->fecha)->format('d/m/Y') }}</td>
          <td>{{ $clase->nivel }}</td>
          <td>{{ $clase->profesor->name }}</td>
          <td>
            <span class="badge badge-{{ $clase->lugares_disponibles > 0 ? 'success' : 'danger' }}">
              {{ $clase->lugares_disponibles }}
            </span>
          </td>
          <td>{{ $clase->lugares }}</td>
          <td>
            @if($clase->lugares_disponibles > 0)
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
              data-target="#reservarModal{{ $clase->id }}">
              <i class="fas fa-calendar-plus"></i> Reservar
            </button>
            @else
            <span class="text-muted">Sin lugares</span>
            @endif
          </td>
        </tr>

        <!-- Modal para reservar -->
        <div class="modal fade" id="reservarModal{{ $clase->id }}" tabindex="-1" role="dialog"
          aria-labelledby="reservarModalLabel{{ $clase->id }}" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="reservarModalLabel{{ $clase->id }}">
                  Reservar Clase - {{ $clase->nivel }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="{{ route('reservaciones.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                  <input type="hidden" name="id_clase" value="{{ $clase->id }}">

                  <div class="row">
                    <div class="col-md-6">
                      <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($clase->fecha)->format('d/m/Y') }}
                    </div>
                    <div class="col-md-6">
                      <strong>Profesor:</strong> {{ $clase->profesor->name }}
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-6">
                      <strong>Nivel:</strong> {{ $clase->nivel }}
                    </div>
                    <div class="col-md-6">
                      <strong>Lugares disponibles:</strong> {{ $clase->lugares_disponibles }}
                    </div>
                  </div>

                  <div class="form-group mt-3">
                    <label for="notas{{ $clase->id }}">Notas adicionales (opcional)</label>
                    <textarea class="form-control" id="notas{{ $clase->id }}" name="notas"
                      rows="3" placeholder="Escribe cualquier nota adicional para tu reservación..."></textarea>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                  <button type="submit" class="btn btn-primary">Confirmar Reservación</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        @empty
        <tr>
          <td colspan="6" class="text-center">No hay clases disponibles para reservar en este momento.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="d-flex justify-content-center">
    {{ $clases->appends(request()->query())->links() }}
  </div>
</div>
@endsection