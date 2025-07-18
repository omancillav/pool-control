<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
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

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        .container button {
            background: linear-gradient(135deg, #0066cc, #0099ff);
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
            transition: all 0.3s ease;
        }

        .container button:hover {
            background: linear-gradient(135deg, #0055aa, #0088ee);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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

        .sign-up {
            left: 50%;
            width: 50%;
            z-index: 10;
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
            left: 0;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: all 0.6s ease-in-out;
            border-radius: 0 150px 150px 0;
            z-index: 1000;
        }

        .toggle {
            background: linear-gradient(135deg, #0066cc 0%, #0099ff 50%, #66ccff 100%);
            color: #fff;
            position: relative;
            left: 0;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: all 0.6s ease-in-out;
            overflow: hidden;
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
            z-index: 2;
        }

        .toggle-panel h1,
        .toggle-panel p,
        .toggle-panel a {
            position: relative;
            z-index: 2;
            color: #fff;
        }

        .toggle-panel h1 {
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .toggle-panel p {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 30px;
        }

        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .floating-elements::before,
        .floating-elements::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .floating-elements::before {
            width: 200px;
            height: 200px;
            top: 15%;
            left: 10%;
            animation-delay: -2s;
        }

        .floating-elements::after {
            width: 150px;
            height: 150px;
            bottom: 15%;
            right: 10%;
            animation-delay: -4s;
        }

        .toggle-panel a.hidden {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            backdrop-filter: blur(10px);
            padding: 10px 20px;
            border-radius: 20px;
            text-decoration: none;
            margin-top: 15px;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .toggle-panel a.hidden:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: white;
            transform: translateY(-2px);
        }

        .toggle-left {
            transform: translateX(0);
        }
    </style>
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