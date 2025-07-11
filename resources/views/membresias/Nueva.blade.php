@extends('adminlte::page')

@section('title', 'Nueva membresía')

@section('css')
<style>
    body {
        background: #E6F0FA;
    }
    .header-wave {
        position: relative;
        background: linear-gradient(90deg, #E6F0FA 0%, #B3D4FC 100%);
        overflow: hidden;
        border-radius: 0 0 32px 32px;
        box-shadow: 0 2px 8px rgba(176,190,197,0.12);
        padding: 16px 24px;
    }
    .wave-svg {
        position: absolute;
        left: 0; right: 0; bottom: 0;
        width: 100%; height: 70px;
        z-index: 0;
    }
    .wibesand-logo {
        font-weight: bold;
        font-size: 2rem;
        color: #FFC107;
        letter-spacing: 2px;
        display: flex;
        align-items: center;
        z-index: 1;
        position: relative;
    }
    .wibesand-logo .logo-icon {
        width: 36px; height: 36px; margin-right: 10px;
        background: #1976D2;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
    }
    .main-content {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(176,190,197,0.12);
        padding: 32px 16px 24px 16px;
        margin-bottom: 28px;
        border: 1px solid #E0E0E0;
    }
    .form-header {
        background: linear-gradient(90deg, #E6F0FA 0%, #B3D4FC 100%);
        border-radius: 12px 12px 0 0;
        padding: 16px 24px;
        margin: -32px -16px 24px -16px;
        box-shadow: 0 2px 4px rgba(176,190,197,0.1);
    }
    .form-title {
        font-size: 1.8rem;
        font-weight: bold;
        color: #222;
        margin: 0;
    }
    .form-control {
        border-radius: 6px;
        border: 1px solid #E0E0E0;
        box-shadow: 0 2px 4px rgba(176,190,197,0.1);
    }
    .form-group label {
        font-weight: bold;
        color: #222;
    }
    .btn-submit {
        background: #1976D2;
        border: 1px solid #1976D2;
        color: #fff;
        border-radius: 6px;
        font-weight: bold;
        padding: 8px 16px;
    }
</style>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        
        form.addEventListener('submit', function(event) {
            let isValid = true;
            const clasesAdquiridas = document.getElementById('clases_adquiridas');
            const clasesDisponibles = document.getElementById('clases_disponibles');
            const clasesOcupadas = document.getElementById('clases_ocupadas');
            
            // Reset error messages
            form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            
            // Validate that available + occupied doesn't exceed acquired
            if (parseInt(clasesDisponibles.value) + parseInt(clasesOcupadas.value) > parseInt(clasesAdquiridas.value)) {
                showError(clasesAdquiridas, 'La suma de clases disponibles y ocupadas no puede ser mayor a las clases adquiridas');
                isValid = false;
            }
            
            if (!isValid) {
                event.preventDefault();
            }
        });
        
        function showError(input, message) {
            input.classList.add('is-invalid');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback';
            errorDiv.textContent = message;
            input.parentNode.appendChild(errorDiv);
        }
    });
</script>
@endpush

@section('content_header')
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
            <path d="M0,70 C360,30 1080,110 1440,70 L1440,70 L0,70 Z" fill="#fff"/>
        </svg>
    </div>
@endsection

@section('content')
    <div class="main-content">
        <div class="form-header">
            <h3 class="form-title">Registrar Nueva Membresía</h3>
        </div>
        <form action="{{ route('membresias.store') }}" method="POST" id="membresiaForm" novalidate>
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="id_usuario">Usuario(*)</label>
                            <select class="form-control @error('id_usuario') is-invalid @enderror" id="id_usuario" name="id_usuario" required 
                                aria-describedby="id_usuario-error" title="Por favor seleccione un cliente">
                                <option value="" disabled selected>Seleccione un cliente</option>
                                @foreach ($usuarios as $usuario)
                                    @if($usuario->rol === 'Cliente')
                                        <option value="{{ $usuario->id }}" {{ old('id_usuario') == $usuario->id ? 'selected' : '' }}>
                                            {{ $usuario->name }} {{ $usuario->last_name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('id_usuario')
                                <div class="invalid-feedback" id="id_usuario-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="clases_adquiridas">Clases Adquiridas(*)</label>
                            <input type="number" class="form-control @error('clases_adquiridas') is-invalid @enderror" 
                                id="clases_adquiridas" name="clases_adquiridas" min="0" 
                                value="{{ old('clases_adquiridas') }}" required
                                aria-describedby="clases_adquiridas-error" title="Ingrese el número de clases adquiridas">
                            @error('clases_adquiridas')
                                <div class="invalid-feedback" id="clases_adquiridas-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="clases_disponibles">Clases Disponibles(*)</label>
                            <input type="number" class="form-control @error('clases_disponibles') is-invalid @enderror" 
                                id="clases_disponibles" name="clases_disponibles" min="0" 
                                value="{{ old('clases_disponibles') }}" required
                                aria-describedby="clases_disponibles-error" title="Ingrese el número de clases disponibles">
                            @error('clases_disponibles')
                                <div class="invalid-feedback" id="clases_disponibles-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="clases_ocupadas">Clases Ocupadas(*)</label>
                            <input type="number" class="form-control @error('clases_ocupadas') is-invalid @enderror" 
                                id="clases_ocupadas" name="clases_ocupadas" min="0" 
                                value="{{ old('clases_ocupadas') }}" required
                                aria-describedby="clases_ocupadas-error" title="Ingrese el número de clases ocupadas">
                            @error('clases_ocupadas')
                                <div class="invalid-feedback" id="clases_ocupadas-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-0" style="text-align:right;">
                <button type="submit" class="btn btn-submit">Registrar Membresía</button>
            </div>
        </form>
    </div>
@endsection