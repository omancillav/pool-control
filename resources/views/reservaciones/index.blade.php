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
          <th>Precio</th>
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
          <td><strong>${{ number_format($clase->precio, 2) }}</strong></td>
          <td>
            <span class="badge badge-{{ $clase->lugares_disponibles > 0 ? 'success' : 'danger' }}">
              {{ $clase->lugares_disponibles }}
            </span>
          </td>
          <td>{{ $clase->lugares }}</td>
          <td>
            @if($clase->lugares_disponibles > 0)
            <form method="POST" action="{{ route('reservaciones.store') }}" style="display: inline;">
              @csrf
              <input type="hidden" name="id_clase" value="{{ $clase->id }}">
              <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-credit-card"></i> Reservar
              </button>
            </form>
            @else
            <span class="text-muted">Sin lugares</span>
            @endif
          </td>
        @empty
        <tr>
          <td colspan="7" class="text-center">No hay clases disponibles para reservar en este momento.</td>
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