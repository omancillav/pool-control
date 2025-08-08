@extends('adminlte::page')

@section('title', 'Procesar Pago - Membresía')

@section('css')
<style>
    .form-control.is-valid {
        border-color: #28a745;
    }
    .form-control.is-invalid {
        border-color: #dc3545;
    }
    .form-control.is-valid:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }
    .form-control.is-invalid:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    .card-body .alert-info {
        border-left: 4px solid #17a2b8;
    }
    .payment-security-icons {
        opacity: 0.8;
        transition: opacity 0.3s;
    }
    .payment-security-icons:hover {
        opacity: 1;
    }
    .paquete-destacado {
        background: linear-gradient(135deg, #1976D2 0%, #1565C0 100%);
        color: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
    }
</style>
@stop

@section('content_header')
    <h1>Procesar Pago - Membresía {{ $paquete['nombre'] }}</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-credit-card"></i> Información de la Membresía y Pago</h3>
                </div>
                <div class="card-body">
                    <!-- Información de la membresía -->
                    <div class="paquete-destacado">
                        <div class="row">
                            <div class="col-md-8">
                                <h4><i class="fas fa-swimming-pool"></i> {{ $paquete['nombre'] }}</h4>
                                <p class="mb-2">{{ $paquete['descripcion'] }}</p>
                                <ul class="list-unstyled">
                                    @foreach($paquete['beneficios'] as $beneficio)
                                        <li><i class="fas fa-check text-warning"></i> {{ $beneficio }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="alert alert-light mb-0">
                                    <h3><i class="fas fa-dollar-sign"></i> Total a Pagar</h3>
                                    <h1 class="text-primary">${{ number_format($paquete['precio'], 2) }} MXN</h1>
                                    <small>{{ $paquete['clases'] }} clases incluidas</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario de pago -->
                    <form method="POST" action="{{ route('membresias.procesar-compra') }}">
                        @csrf
                        <input type="hidden" name="paquete" value="{{ $tipoPaquete }}">
                        
                        <div class="form-group">
                            <label for="metodo_pago">Método de Pago *</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metodo_pago" id="pago_online" value="online" checked>
                                <label class="form-check-label" for="pago_online">
                                    <i class="fas fa-credit-card text-success"></i> <strong>Pago en Línea (Simulado)</strong>
                                    <small class="d-block text-muted">El pago se procesará inmediatamente y tu membresía será activada.</small>
                                </label>
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="radio" name="metodo_pago" id="pago_fisico" value="fisico">
                                <label class="form-check-label" for="pago_fisico">
                                    <i class="fas fa-money-bill text-warning"></i> <strong>Pago Físico en Instalaciones</strong>
                                    <small class="d-block text-muted">Puedes pagar en efectivo o tarjeta en nuestras instalaciones. Tu membresía quedará reservada.</small>
                                </label>
                            </div>
                        </div>

                        <!-- Simulación de datos de tarjeta (solo para pago online) -->
                        <div id="datos_tarjeta" class="card mt-3">
                            <div class="card-header bg-primary text-white">
                                <h6><i class="fas fa-credit-card"></i> Información de Pago Seguro</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label>Nombre del Titular *</label>
                                        <input type="text" class="form-control" name="nombre_titular" 
                                               placeholder="Nombre completo" value="{{ auth()->user()->name }}" readonly>
                                        <small class="text-muted">Este nombre debe coincidir con el de tu tarjeta</small>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label>Número de Tarjeta *</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fab fa-cc-visa text-primary"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="numero_tarjeta" id="numero_tarjeta"
                                                   placeholder="1234 5678 9012 3456" value="4532 1234 5678 9012" 
                                                   maxlength="19" pattern="[0-9\s]{13,19}" 
                                                   title="Solo números y espacios, entre 13 y 19 caracteres">
                                        </div>
                                        <small class="text-muted">Ingresa los 16 dígitos de tu tarjeta</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Fecha de Expiración *</label>
                                        <input type="text" class="form-control" name="fecha_exp" id="fecha_exp"
                                               placeholder="MM/AA" value="12/26" maxlength="5" 
                                               pattern="(0[1-9]|1[0-2])\/([0-9]{2})"
                                               title="Formato: MM/AA (ej: 12/26)">
                                        <small class="text-muted">Formato: MM/AA</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Código de Seguridad (CVV) *</label>
                                        <input type="text" class="form-control" name="cvv" id="cvv"
                                               placeholder="123" value="123" maxlength="4" 
                                               pattern="[0-9]{3,4}"
                                               title="3 o 4 dígitos numéricos">
                                        <small class="text-muted">3 dígitos detrás de tu tarjeta</small>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label>Email de Confirmación *</label>
                                        <input type="email" class="form-control" name="email_confirmacion"
                                               placeholder="correo@ejemplo.com" 
                                               value="{{ auth()->user()->email }}" readonly>
                                        <small class="text-muted">Te enviaremos la confirmación de pago a este email</small>
                                    </div>
                                </div>
                                
                                <div class="row payment-security-icons">
                                    <div class="col-md-6">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <i class="fas fa-shield-alt fa-2x text-success mb-2"></i>
                                                <small class="d-block"><strong>Pago 100% Seguro</strong></small>
                                                <small class="text-muted">Encriptación SSL 256-bit</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <i class="fas fa-clock fa-2x text-info mb-2"></i>
                                                <small class="d-block"><strong>Activación Inmediata</strong></small>
                                                <small class="text-muted">Membresía activa al instante</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-info mt-3">
                                    <i class="fas fa-info-circle"></i> 
                                    <strong>Nota Académica:</strong> Este es un sistema de pago simulado para fines educativos. 
                                    Los datos de tarjeta son de prueba y no se procesará ninguna transacción real.
                                    <br><small class="mt-2 d-block">
                                        <strong>Datos de prueba válidos:</strong> Número: 4532 1234 5678 9012, Exp: 12/26, CVV: 123
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="notas">Notas adicionales (opcional)</label>
                            <textarea class="form-control" id="notas" name="notas" rows="3" placeholder="Alguna nota especial sobre tu membresía..."></textarea>
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-lock"></i> Procesar Pago y Activar Membresía
                            </button>
                            <a href="{{ route('membresias.comprar') }}" class="btn btn-secondary btn-lg ml-2">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        // Mostrar/ocultar datos de tarjeta según el método de pago
        function toggleDatosTarjeta() {
            if ($('#pago_online').is(':checked')) {
                $('#datos_tarjeta').show();
                // Hacer campos obligatorios
                $('#numero_tarjeta, #fecha_exp, #cvv').prop('required', true);
            } else {
                $('#datos_tarjeta').hide();
                // Quitar obligatoriedad
                $('#numero_tarjeta, #fecha_exp, #cvv').prop('required', false);
            }
        }

        // Ejecutar al cargar la página
        toggleDatosTarjeta();

        // Ejecutar cuando cambien los radio buttons
        $('input[name="metodo_pago"]').change(function() {
            toggleDatosTarjeta();
        });

        // Formatear número de tarjeta (agregar espacios cada 4 dígitos)
        $('#numero_tarjeta').on('input', function() {
            let value = $(this).val().replace(/\D/g, ''); // Solo números
            let formattedValue = value.replace(/(\d{4})(?=\d)/g, '$1 '); // Agregar espacios
            $(this).val(formattedValue);
            
            // Validar longitud
            if (value.length < 13 || value.length > 19) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid').addClass('is-valid');
            }
        });

        // Formatear fecha de expiración (MM/AA)
        $('#fecha_exp').on('input', function() {
            let value = $(this).val().replace(/\D/g, ''); // Solo números
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            $(this).val(value);

            // Validar formato y fecha
            let regex = /^(0[1-9]|1[0-2])\/([0-9]{2})$/;
            if (regex.test(value)) {
                let [month, year] = value.split('/');
                let currentYear = new Date().getFullYear() % 100;
                let currentMonth = new Date().getMonth() + 1;
                
                if (parseInt(year) > currentYear || (parseInt(year) == currentYear && parseInt(month) >= currentMonth)) {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                } else {
                    $(this).addClass('is-invalid');
                }
            } else {
                $(this).addClass('is-invalid');
            }
        });

        // Validar CVV (solo números)
        $('#cvv').on('input', function() {
            let value = $(this).val().replace(/\D/g, ''); // Solo números
            $(this).val(value);
            
            if (value.length >= 3 && value.length <= 4) {
                $(this).removeClass('is-invalid').addClass('is-valid');
            } else {
                $(this).addClass('is-invalid');
            }
        });

        // Validación del formulario antes de enviar
        $('form').on('submit', function(e) {
            if ($('#pago_online').is(':checked') && $('#datos_tarjeta').is(':visible')) {
                let esValido = true;
                let errores = [];

                // Validar número de tarjeta
                let numeroTarjeta = $('#numero_tarjeta').val().replace(/\s/g, '');
                if (numeroTarjeta.length < 13 || numeroTarjeta.length > 19 || !/^\d+$/.test(numeroTarjeta)) {
                    esValido = false;
                    errores.push('Número de tarjeta inválido');
                    $('#numero_tarjeta').addClass('is-invalid');
                }

                // Validar fecha de expiración
                let fechaExp = $('#fecha_exp').val();
                if (!/^(0[1-9]|1[0-2])\/([0-9]{2})$/.test(fechaExp)) {
                    esValido = false;
                    errores.push('Fecha de expiración inválida');
                    $('#fecha_exp').addClass('is-invalid');
                }

                // Validar CVV
                let cvv = $('#cvv').val();
                if (!/^[0-9]{3,4}$/.test(cvv)) {
                    esValido = false;
                    errores.push('CVV inválido');
                    $('#cvv').addClass('is-invalid');
                }

                if (!esValido) {
                    e.preventDefault();
                    alert('Por favor, corrige los siguientes errores:\n• ' + errores.join('\n• '));
                    return false;
                }

                // Mostrar loading
                $(this).find('button[type="submit"]').prop('disabled', true)
                    .html('<i class="fas fa-spinner fa-spin"></i> Procesando pago...');
            }
        });

        // Prevenir pegado de texto no numérico en campos numéricos
        $('#numero_tarjeta, #cvv').on('paste', function(e) {
            setTimeout(() => {
                let value = $(this).val().replace(/\D/g, '');
                $(this).val(value);
                $(this).trigger('input');
            }, 10);
        });
    });
</script>
@stop
