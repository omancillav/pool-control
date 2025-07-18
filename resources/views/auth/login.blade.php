<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión / Registrarse</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <div class="container" id="container">
        <!-- Formulario de Inicio de Sesión -->
        <div class="form-container sign-in">
            <form action="{{ route('login') }}" method="post">
                @csrf
                <h1>Iniciar Sesión</h1>
                <span>Use su correo y contraseña</span>
                <div class="input-group">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="text" name="email" placeholder="Correo electrónico" value="{{ old('email') }}" required>
                </div>
                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="Contraseña" required id="password">
                    <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
                </div>
                <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                <button type="submit">Iniciar Sesión</button>
                <section class="divider-section">
                    <div class="divider"></div>
                    <p class="divider-text">o inicie sesión con</p>
                    <div class="divider"></div>
                </section>
                {{-- Boton de google --}}
                <a href="{{ route('auth.google.redirect') }}" class="google-login-button">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google logo">
                    <span>Google</span>
                </a>
                {{-- Boton de facebook --}}
                <a href="{{ route('auth.facebook.redirect') }}" class="facebook-login-button">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook logo">
                    <span>Facebook</span>
                </a>
                <a href="{{ route('privacy.notice') }}" target="_blank" style="font-weight: bold; color: #0066cc; margin: 10px 0;">Aviso de Privacidad</a>
            </form>
        </div>

        <!-- Paneles Deslizantes -->
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-right">
                    <div class="floating-elements"></div>
                    <h1>¡Bienvenido de vuelta!</h1>
                    <p>Ingresa tus datos para usar todas las funciones del sitio.</p>
                    <a href="/" class="home-btn">
                        <i class="fas fa-home"></i> Inicio
                    </a>
                    <a href="{{ route('register') }}" class="hidden">Regístrate</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');

            if (togglePassword) {
                togglePassword.addEventListener('click', function() {
                    // Cambiar el tipo de input
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);

                    // Cambiar el icono
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
</body>

</html>