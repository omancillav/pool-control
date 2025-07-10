@extends('adminlte::page')

@section('title', 'Nuevo Usuario')

@section('content_header')
    <h1>Nuevo Usuario</h1>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        
        form.addEventListener('submit', function(event) {
            let isValid = true;
            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const passwordConfirmation = document.getElementById('password_confirmation');
            
            // Reset error messages
            document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            
            // Validate name
            if (!name.value.trim()) {
                showError(name, 'El nombre es obligatorio');
                isValid = false;
            }
            
            // Validate email
            if (!email.value.trim()) {
                showError(email, 'El correo electrónico es obligatorio');
                isValid = false;
            } else if (!/\S+@\S+\.\S+/.test(email.value)) {
                showError(email, 'Por favor ingrese un correo electrónico válido');
                isValid = false;
            }
            
            // Validate password
            if (!password.value) {
                showError(password, 'La contraseña es obligatoria');
                isValid = false;
            } else if (password.value.length < 8) {
                showError(password, 'La contraseña debe tener al menos 8 caracteres');
                isValid = false;
            }
            
            // Validate password confirmation
            if (!passwordConfirmation.value) {
                showError(passwordConfirmation, 'Por favor confirme la contraseña');
                isValid = false;
            } else if (password.value !== passwordConfirmation.value) {
                showError(passwordConfirmation, 'Las contraseñas no coinciden');
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
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Registrar Nuevo Usuario</h3>
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
            <div class="card-footer">
                <button type="submit" class="btn btn-success float-right">Registrar Usuario</button>
            </div>
        </form>
    </div>
@endsection