@extends('adminlte::page')

@section('title', 'Nuevo Usuario')

@section('css')
<link rel="stylesheet" href="{{ asset('css/list.css') }}">
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('userForm');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');

        // Validar que las contraseñas coincidan
        function validatePassword() {
            if (password.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity("Las contraseñas no coinciden");
            } else {
                confirmPassword.setCustomValidity('');
            }
        }

        if (password && confirmPassword) {
            password.onchange = validatePassword;
            confirmPassword.onkeyup = validatePassword;
        }

        // Manejar el envío del formulario
        if (form) {
            form.addEventListener('submit', function(event) {
                let isValid = true;

                // Validar campos requeridos
                const requiredFields = form.querySelectorAll('[required]');
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        showError(field, 'Este campo es obligatorio');
                        isValid = false;
                    }
                });

                // Validar formato de email
                const emailField = document.getElementById('email');
                if (emailField && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailField.value)) {
                    showError(emailField, 'Ingrese un correo electrónico válido');
                    isValid = false;
                }

                // Validar longitud mínima de contraseña
                if (password && password.value.length > 0 && password.value.length < 8) {
                    showError(password, 'La contraseña debe tener al menos 8 caracteres');
                    isValid = false;
                }

                if (!isValid) {
                    event.preventDefault();
                    event.stopPropagation();
                }
            });
        }

        // Mostrar mensajes de error
        function showError(input, message) {
            // Eliminar mensajes de error existentes
            const existingError = input.parentNode.querySelector('.invalid-feedback');
            if (existingError) {
                existingError.remove();
            }

            // Agregar clase de error al campo
            input.classList.add('is-invalid');

            // Crear y mostrar mensaje de error
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
        <h3 class="page-title">Registrar Nuevo Usuario</h3>
    </div>
    <form action="{{ route('usuarios.store') }}" method="POST" id="userForm" novalidate>
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="name">Nombre(*)</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email">Email(*)</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="rol">Rol(*)</label>
                        <select class="form-control" id="rol" name="rol" required>
                            <option value="Administrador">Administrador</option>
                            <option value="Cliente">Cliente</option>
                            <option value="Profesor">Profesor</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="password">Contraseña(*)</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="password_confirmation">Confirmar Contraseña(*)</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation"
                            name="password_confirmation" required>
                        @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-white border-0" style="text-align:right;">
            <button type="submit" class="btn" style="background:#1976D2; color:#fff; font-weight:bold; border-radius:6px;">Registrar Usuario</button>
        </div>
    </form>
</div>
@endsection