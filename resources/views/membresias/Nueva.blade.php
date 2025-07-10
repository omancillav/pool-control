@extends('adminlte::page')

@section('title', 'Nueva membresía')

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
    <h1>Nueva Membresía</h1>
@endsection

@section('content')
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Registrar Nueva Membresía</h3>
        </div>
        <form action="{{ route('membresias.store') }}" method="POST" id="membresiaForm" novalidate>
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="id_usuario">Usuario(*)</label>
                            <select class="form-control @error('id_usuario') is-invalid @enderror" id="id_usuario" name="id_usuario" required 
                                title="Por favor seleccione un cliente">
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
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="clases_adquiridas">Clases Adquiridas(*)</label>
                            <input type="number" class="form-control @error('clases_adquiridas') is-invalid @enderror" 
                                id="clases_adquiridas" name="clases_adquiridas" min="0" 
                                value="{{ old('clases_adquiridas') }}" required
                                title="Ingrese el número de clases adquiridas">
                            @error('clases_adquiridas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="clases_disponibles">Clases Disponibles(*)</label>
                            <input type="number" class="form-control @error('clases_disponibles') is-invalid @enderror" 
                                id="clases_disponibles" name="clases_disponibles" min="0" 
                                value="{{ old('clases_disponibles') }}" required
                                title="Ingrese el número de clases disponibles">
                            @error('clases_disponibles')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="clases_ocupadas">Clases Ocupadas(*)</label>
                            <input type="number" class="form-control @error('clases_ocupadas') is-invalid @enderror" 
                                id="clases_ocupadas" name="clases_ocupadas" min="0" 
                                value="{{ old('clases_ocupadas') }}" required
                                title="Ingrese el número de clases ocupadas">
                            @error('clases_ocupadas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success float-right">Registrar Membresía</button>
            </div>
        </form>
    </div>
@endsection

@section('css')
    {{-- Estilos personalizados opcionales --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endsection

@section('js')
    {{-- Scripts personalizados opcionales --}}
@endsection