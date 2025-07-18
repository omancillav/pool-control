<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>

<body>
    <div class="container">
        <!-- Formulario de Registro -->
        <div class="form-container sign-up">
            <form action="{{ route('register') }}" method="post">
                @csrf
                <h1>Crear una Cuenta</h1>
                <span>Usa tu correo para registrarte</span>
                <div class="input-group">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="name" placeholder="Nombre" value="{{ old('name') }}" required>
                </div>
                @error('name')
                <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
                <div class="input-group">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" placeholder="Correo electrónico" value="{{ old('email') }}" required>
                </div>
                @error('email')
                <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="Contraseña" required id="password">
                    <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
                </div>
                @error('password')
                <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password_confirmation" placeholder="Confirmar Contraseña" required id="password_confirmation">
                    <i class="fa-solid fa-eye toggle-password" id="togglePasswordConfirmation"></i>
                </div>
                @error('password_confirmation')
                <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
                <p style="font-size: 12px; margin: 10px 0;">Al registrarte, aceptas nuestro <a href="{{ route('privacy.notice') }}" target="_blank" style="font-weight: bold; color: #0066cc; margin: 0;">Aviso de Privacidad</a>.</p>
                <button type="submit">Registrarse</button>
            </form>
        </div>

        <!-- Panel de Bienvenida -->
        <div class="toggle-container">
            <div class="toggle">
                    <div class="toggle-panel toggle-left">
                        <div class="floating-elements"></div>
                        <h1>¡Hola, Amigo!</h1>
                        <p>Regístrate con tus datos personales para usar todas las funciones del sitio.</p>
                        <a href="{{ route('login') }}" class="hidden">Iniciar Sesión</a>
                    </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function setupPasswordToggle(passwordInputId, toggleElementId) {
                const passwordInput = document.getElementById(passwordInputId);
                const toggleElement = document.getElementById(toggleElementId);

                if (passwordInput && toggleElement) {
                    toggleElement.addEventListener('click', function() {
                        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                        passwordInput.setAttribute('type', type);
                        this.classList.toggle('fa-eye');
                        this.classList.toggle('fa-eye-slash');
                    });
                }
            }
            setupPasswordToggle('password', 'togglePassword');
            setupPasswordToggle('password_confirmation', 'togglePasswordConfirmation');
        });
    </script>
</body>

</html>