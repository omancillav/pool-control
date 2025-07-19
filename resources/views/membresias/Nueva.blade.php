@extends('adminlte::page')

@section('title', 'Nueva membresía')

@section('css')
<link rel="stylesheet" href="{{ asset('css/list.css') }}">
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
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
        <h3 class="page-title">Registrar Nueva Membresía</h3>
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