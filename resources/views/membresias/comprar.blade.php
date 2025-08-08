@extends('adminlte::page')

@section('title', 'Comprar Membresía')

@section('css')
<link rel="stylesheet" href="{{ asset('css/panel.css') }}">
<style>
.paquete-card {
    border: 2px solid #e3e6f0;
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 20px;
    transition: all 0.3s ease;
    background: white;
}

.paquete-card:hover {
    border-color: #1976D2;
    box-shadow: 0 5px 15px rgba(25, 118, 210, 0.1);
    transform: translateY(-2px);
}

.paquete-card.recomendado {
    border-color: #1976D2;
    background: linear-gradient(135deg, #f8f9fa 0%, #e3f2fd 100%);
}

.paquete-precio {
    font-size: 2.5rem;
    font-weight: bold;
    color: #1976D2;
}

.paquete-nombre {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 10px;
}

.paquete-descripcion {
    color: #6c757d;
    margin-bottom: 20px;
}

.beneficio-item {
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
}

.beneficio-item:last-child {
    border-bottom: none;
}

.beneficio-item i {
    color: #28a745;
    margin-right: 10px;
}

.btn-comprar {
    width: 100%;
    padding: 12px;
    font-size: 1.1rem;
    font-weight: 600;
}

.membresia-actual {
    background: #d4edda;
    border: 1px solid #c3e6cb;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 30px;
}

.badge-recomendado {
    position: absolute;
    top: -10px;
    right: 20px;
    background: #ff6b35;
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}
</style>
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
    <div>
        <a href="{{ route('reservaciones.index') }}" class="btn btn-outline-light btn-sm">
            <i class="fas fa-arrow-left"></i> Volver a Clases
        </a>
    </div>
  </div>
  <svg class="wave-svg" viewBox="0 0 1440 70" preserveAspectRatio="none">
    <path d="M0,60 C360,70 1080,50 1440,60 L1440,70 L0,70 Z" fill="#f4f6f9" />
  </svg>
</div>

<div class="main-content">
  <div class="content-header">
    <h3 class="page-title">
        <i class="fas fa-swimming-pool text-primary"></i>
        Comprar Membresía
    </h3>
    <p class="text-muted">Selecciona el paquete que mejor se adapte a tus necesidades</p>
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

  @if($membresiaActual)
  <div class="membresia-actual">
    <h5><i class="fas fa-info-circle text-success"></i> Tu Membresía Actual</h5>
    <div class="row">
      <div class="col-md-3">
        <strong>Clases Totales:</strong> {{ $membresiaActual->clases_adquiridas }}
      </div>
      <div class="col-md-3">
        <strong>Clases Disponibles:</strong> 
        <span class="badge badge-success">{{ $membresiaActual->clases_disponibles }}</span>
      </div>
      <div class="col-md-3">
        <strong>Clases Utilizadas:</strong> {{ $membresiaActual->clases_ocupadas }}
      </div>
      <div class="col-md-3">
        <strong>Progreso:</strong> {{ $membresiaActual->porcentajeUtilizado() }}%
      </div>
    </div>
    <p class="mt-2 mb-0 text-muted">
      <i class="fas fa-lightbulb"></i> 
      Puedes comprar otro paquete para agregar más clases a tu membresía actual.
    </p>
  </div>
  @endif

  <div class="row">
    @foreach($paquetes as $index => $paquete)
    <div class="col-md-4">
      <div class="paquete-card {{ $index === 1 ? 'recomendado' : '' }} position-relative">
        @if($index === 1)
          <span class="badge-recomendado">RECOMENDADO</span>
        @endif
        
        <div class="text-center">
          <div class="paquete-nombre">{{ $paquete['nombre'] }}</div>
          <div class="paquete-precio">${{ number_format($paquete['precio'], 0) }}</div>
          <div class="paquete-descripcion">{{ $paquete['descripcion'] }}</div>
        </div>

        <div class="beneficios mb-4">
          @foreach($paquete['beneficios'] as $beneficio)
          <div class="beneficio-item">
            <i class="fas fa-check-circle"></i>
            {{ $beneficio }}
          </div>
          @endforeach
        </div>

        <form method="POST" action="{{ route('membresias.procesar-compra') }}">
          @csrf
          <input type="hidden" name="paquete" value="{{ ['basico', 'intermedio', 'premium'][$index] }}">
          
          <div class="form-group">
            <label><strong>Método de Pago:</strong></label>
            <div class="custom-control custom-radio">
              <input class="custom-control-input" type="radio" id="online{{ $index }}" name="metodo_pago" value="online" checked>
              <label for="online{{ $index }}" class="custom-control-label">
                <i class="fas fa-credit-card"></i> Pago en línea
              </label>
            </div>
            <div class="custom-control custom-radio">
              <input class="custom-control-input" type="radio" id="fisico{{ $index }}" name="metodo_pago" value="fisico">
              <label for="fisico{{ $index }}" class="custom-control-label">
                <i class="fas fa-money-bill"></i> Pago físico
              </label>
            </div>
          </div>

          <button type="submit" class="btn btn-primary btn-comprar">
            <i class="fas fa-shopping-cart"></i>
            Comprar Paquete
          </button>
        </form>
      </div>
    </div>
    @endforeach
  </div>

  <div class="row mt-4">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h5><i class="fas fa-question-circle text-info"></i> Preguntas Frecuentes</h5>
          <div class="row">
            <div class="col-md-6">
              <h6>¿Cómo funciona la membresía?</h6>
              <p class="text-muted">Cada paquete te otorga un número específico de clases que puedes usar para reservar. Las clases no tienen fecha de vencimiento.</p>
              
              <h6>¿Puedo comprar múltiples paquetes?</h6>
              <p class="text-muted">Sí, las clases se acumularán en tu membresía actual.</p>
            </div>
            <div class="col-md-6">
              <h6>¿Qué pasa si cancelo una clase?</h6>
              <p class="text-muted">La clase cancelada se devuelve automáticamente a tu membresía para uso futuro.</p>
              
              <h6>Métodos de pago</h6>
              <p class="text-muted">Pago en línea: Procesamiento inmediato. Pago físico: Puedes pagar en el centro deportivo.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
