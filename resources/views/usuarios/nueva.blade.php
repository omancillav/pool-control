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
    }
    .wibesand-logo .logo-icon {
        width: 36px; height: 36px; margin-right: 10px;
        background: #1976D2;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
    }
    .encabezado-titulo {
        text-align: center;
        font-size: 2.7rem;
        font-weight: 800;
        color: #222;
        margin-bottom: 0.3rem;
    }
    .encabezado-punto {
        display: flex; justify-content: center;
    }
    .encabezado-punto svg {
        margin-top: 0.2rem;
    }
    .bienvenida-section {
        display: flex; align-items: center;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(176,190,197,0.14);
        padding: 18px 30px;
        margin: -32px auto 24px auto;
        max-width: 540px;
        position: relative;
        z-index: 2;
    }
    .bienvenida-icon {
        background: #ECEFF1;
        border-radius: 50%;
        width: 48px; height: 48px;
        display: flex; align-items: center; justify-content: center;
        margin-right: 18px;
    }
    .bienvenida-txt {
        font-size: 1.5rem;
        font-weight: bold;
        color: #222;
    }
    .main-content {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(176,190,197,0.12);
        padding: 32px 16px 24px 16px;
        margin-bottom: 28px;
        border: 1px solid #E0E0E0;
    }
    .card-home {
        border-radius: 12px;
        border: 1px solid #E0E0E0;
        box-shadow: 0 2px 8px rgba(176,190,197,0.12);
        background: #fff;
    }
</style>

@extends('adminlte::page')

@section('title', 'Nuevo Usuario')

@section('content_header')
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
    <div class="header-wave py-4 px-4 mb-0">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div class="wibesand-logo">
                <span class="logo-icon">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Logo" style="width:32px; height:32px; border-radius:50%; object-fit:cover; background:#1976D2;" />
                </span>
                Pool Control
            </div>
            <div></div>
        </div>
    </div>
    <div class="main-content">

        <div class="encabezado-titulo">Registrar Nuevo Usuario</div>
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