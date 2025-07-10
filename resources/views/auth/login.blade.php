<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión / Registrarse</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }

        body {
            background-color: #f4f7fa;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
            position: relative;
            overflow: hidden;
            width: 960px;
            max-width: 100%;
            min-height: 600px;
        }

        .container h1 {
            font-size: 2.5em;
            margin-bottom: 15px;
        }

        .container p {
            font-size: 16px;
            line-height: 22px;
            letter-spacing: 0.3px;
            margin: 20px 0;
        }

        .container span {
            font-size: 14px;
        }

        .container a {
            color: #333;
            font-size: 15px;
            text-decoration: none;
            margin: 15px 0 10px;
        }

        .container button {
            background-color: #3AB397;
            color: #fff;
            font-size: 14px;
            padding: 12px 50px;
            border: 1px solid transparent;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-top: 10px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }

        .container button:hover {
            background-color: #32a289;
        }

        .container a.hidden {
            background-color: transparent;
            color: #fff;
            font-size: 14px;
            padding: 12px 50px;
            border: 1px solid #fff;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            text-decoration: none;
        }

        .container form {
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            height: 100%;
        }

        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
        }

        .sign-in {
            left: 0;
            width: 50%;
            z-index: 2;
        }

        .container.toggle .sign-in {
            transform: translateX(100%);
        }

        .sign-up {
            left: 0;
            width: 50%;
            opacity: 0;
            z-index: 1;
        }

        .container.toggle .sign-up {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            animation: move 0.6s;
        }

        @keyframes move {
            0%, 49.99% {
                opacity: 0;
                z-index: 1;
            }
            50%, 100% {
                opacity: 1;
                z-index: 5;
            }
        }

        .input-group {
            position: relative;
            width: 100%;
            margin: 8px 0;
        }

        .input-group i:not(.toggle-password) {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        .input-group input {
            width: 100%;
            padding: 15px 45px 15px 45px;
            background-color: #eee;
            border: none;
            border-radius: 8px;
            outline: none;
            font-size: 14px;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #aaa;
        }

        .toggle-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: all 0.6s ease-in-out;
            border-radius: 150px 0 0 150px;
            z-index: 1000;
        }

        .container.toggle .toggle-container {
            transform: translateX(-100%);
            border-radius: 0 150px 150px 0;
        }

        .toggle {
            background: linear-gradient(to right, #3AA8AD, #3AB397);
            height: 100%;
            color: #fff;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: all 0.6s ease-in-out;
        }

        .container.toggle .toggle {
            transform: translateX(50%);
        }

        .toggle-panel {
            position: absolute;
            width: 50%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 30px;
            text-align: center;
            top: 0;
            transform: translateX(0);
            transition: all 0.6s ease-in-out;
        }

        .toggle-left {
            transform: translateX(-200%);
        }

        .container.toggle .toggle-left {
            transform: translateX(0);
        }

        .toggle-right {
            right: 0;
            transform: translateX(0);
        }

        .container.toggle .toggle-right {
            transform: translateX(200%);
        }

        .divider {
            margin: 15px 0;
            font-size: 13px;
            color: #888;
            width: 100%;
            text-align: center;
        }

        .google-login-button {
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            padding: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #fff;
            width: 100%;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .google-login-button:hover {
            background-color: #f5f5f5;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .google-login-button img {
            width: 24px;
            height: 24px;
            margin-right: 12px;
        }

        .google-login-button span {
            color: #333;
            font-weight: 500;
            font-size: 16px;
            line-height: 1;
        }

        .facebook-login-button {
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            padding: 12px;
            border-radius: 8px;
            background-color: #1877F2;
            width: 100%;
            transition: background-color 0.3s, box-shadow 0.3s;
            border: 1px solid #1877F2;
            margin-top: 10px;
        }

        .facebook-login-button:hover {
            background-color: #166fe5;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .facebook-login-button img {
            width: 24px;
            height: 24px;
            margin-right: 12px;
        }

        .facebook-login-button span {
            color: #fff;
            font-weight: 500;
            font-size: 16px;
            line-height: 1;
        }
    </style>
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
                <div class="divider">o inicie sesión con</div>
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
                <a href="{{ route('privacy.notice') }}" target="_blank">Aviso de Privacidad</a>
            </form>
        </div>

        <!-- Paneles Deslizantes -->
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-right">
                    <h1>¡Hola, Amigo!</h1>
                    <p>Regístrate con tus datos personales para usar todas las funciones del sitio.</p>
                    <a href="{{ route('register') }}" class="hidden">Regístrate</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');

            if (togglePassword) {
                togglePassword.addEventListener('click', function () {
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