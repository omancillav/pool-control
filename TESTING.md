# Pool Control - Testing Guide

## Configuración de Pruebas

Este proyecto utiliza PHPUnit para pruebas automatizadas con una configuración completa que incluye:

- ✅ **Tests Unitarios**: Validación de modelos, relaciones y lógica de negocio
- ✅ **Tests de Integración**: Verificación de controladores y middleware
- ✅ **Tests de Autenticación**: Login, registro y autorización por roles
- ✅ **Tests de Activity Log**: Registro de actividades del sistema
- ✅ **Factories**: Generación de datos de prueba realistas
- ✅ **CI/CD**: GitHub Actions para ejecución automática

## Estructura de Tests

```
tests/
├── Feature/                    # Tests de integración
│   ├── AuthenticationTest.php  # Autenticación y autorización
│   ├── UserControllerTest.php  # CRUD de usuarios
│   ├── MembresiaControllerTest.php # CRUD de membresías
│   ├── ClaseControllerTest.php # CRUD de clases
│   ├── RoleMiddlewareTest.php  # Middleware de roles
│   └── ActivityLogTest.php     # Registro de actividades
├── Unit/                       # Tests unitarios
│   ├── UserModelTest.php       # Modelo User
│   ├── MembresiaModelTest.php  # Modelo Membresia
│   ├── ClaseModelTest.php      # Modelo Clase
│   └── RelationshipsTest.php   # Relaciones entre modelos
└── TestCase.php                # Configuración base
```

## Comandos de Testing

### Ejecutar todos los tests
```bash
composer test
```

### Ejecutar solo tests unitarios
```bash
composer test-unit
```

### Ejecutar solo tests de integración
```bash
composer test-feature
```

### Ejecutar tests con cobertura
```bash
composer test-coverage
```

### Generar reporte HTML de cobertura
```bash
composer test-coverage-html
```

### Comandos directos con Artisan
```bash
# Todos los tests
php artisan test

# Tests específicos
php artisan test tests/Unit/UserModelTest.php
php artisan test tests/Feature/AuthenticationTest.php

# Con filtros
php artisan test --filter=user_can_login
php artisan test --group=authentication

# Con cobertura
php artisan test --coverage
php artisan test --coverage-html coverage
```

## Configuración del Entorno de Testing

### Base de Datos
- Utiliza SQLite en memoria (`:memory:`) para mayor velocidad
- Se ejecuta `RefreshDatabase` en cada test para garantizar limpieza
- Los seeders se ejecutan automáticamente

### Variables de Entorno (phpunit.xml)
```xml
<env name="APP_ENV" value="testing"/>
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
<env name="CACHE_STORE" value="array"/>
<env name="SESSION_DRIVER" value="array"/>
<env name="QUEUE_CONNECTION" value="sync"/>
```

## Factories Disponibles

### UserFactory
```php
// Usuario básico
User::factory()->create();

// Usuario con rol específico
User::factory()->create(['rol' => 'Administrador']);
User::factory()->create(['rol' => 'Profesor']);
User::factory()->create(['rol' => 'Cliente']);
```

### MembresiaFactory
```php
// Membresía básica
Membresia::factory()->create();

// Membresía agotada (sin clases disponibles)
Membresia::factory()->agotada()->create();

// Membresía nueva (todas las clases disponibles)
Membresia::factory()->nueva()->create();
```

### ClaseFactory
```php
// Clase básica
Clase::factory()->create();

// Clase llena
Clase::factory()->completa()->create();

// Clase vacía
Clase::factory()->vacia()->create();

// Clase para hoy/mañana
Clase::factory()->hoy()->create();
Clase::factory()->manana()->create();

// Clase pasada
Clase::factory()->pasada()->create();
```

## Casos de Prueba Cubiertos

### 🔐 Autenticación y Autorización
- ✅ Login con credenciales válidas/inválidas
- ✅ Registro de nuevos usuarios
- ✅ Logout
- ✅ Protección de rutas por autenticación
- ✅ Control de acceso por roles (Admin, Profesor, Cliente)

### 👥 Gestión de Usuarios
- ✅ CRUD completo de usuarios
- ✅ Validación de datos (email único, roles válidos)
- ✅ Búsqueda y filtrado
- ✅ Restricciones por rol

### 💳 Gestión de Membresías
- ✅ CRUD completo de membresías
- ✅ Validación de consistencia (clases adquiridas = disponibles + ocupadas)
- ✅ Relación con usuarios
- ✅ Búsqueda y filtrado

### 🏊 Gestión de Clases
- ✅ CRUD completo de clases
- ✅ Validación de capacidad (lugares total = ocupados + disponibles)
- ✅ Inscripción de clientes
- ✅ Validación de fechas (no en el pasado)
- ✅ Relación profesor-clase

### 📊 Activity Log
- ✅ Registro de creación, actualización y eliminación
- ✅ Mensajes personalizados en español
- ✅ Almacenamiento de atributos modificados
- ✅ Consulta de historial por modelo

### 🔗 Relaciones entre Modelos
- ✅ User -> Membresias (uno a muchos)
- ✅ User -> Clases como profesor (uno a muchos)
- ✅ User -> Clases como cliente (muchos a muchos)
- ✅ Eager loading de relaciones

## Integración Continua (CI/CD)

### GitHub Actions
El archivo `.github/workflows/tests.yml` ejecuta automáticamente:

1. **Setup del entorno**: PHP 8.2, MySQL, dependencias
2. **Preparación**: Variables de entorno, permisos, base de datos
3. **Ejecución**: Tests con cobertura de código
4. **Reporte**: Subida de cobertura a Codecov

### Triggers
- ✅ Push a `main` y `develop`
- ✅ Pull requests a `main`
- ✅ Ejecución manual desde GitHub

## Métricas y Cobertura

### Objetivos de Cobertura
- **Modelos**: 95%+ de cobertura
- **Controladores**: 90%+ de cobertura
- **Middleware**: 100% de cobertura
- **General**: 85%+ de cobertura total

### Reportes
```bash
# Generar reporte HTML
composer test-coverage-html

# Ver reporte en navegador
open coverage/index.html  # macOS
start coverage/index.html # Windows
```

## Mejores Prácticas

### 📝 Nomenclatura de Tests
```php
/** @test */
public function it_can_create_a_user() { }

/** @test */
public function admin_can_access_admin_routes() { }

/** @test */
public function user_creation_is_logged() { }
```

### 🏗️ Estructura de Tests
```php
// Arrange (Preparar)
$user = User::factory()->create();

// Act (Actuar)
$response = $this->actingAs($user)->get('/route');

// Assert (Verificar)
$response->assertStatus(200);
$this->assertDatabaseHas('table', ['field' => 'value']);
```

### 🔧 Configuración por Test
```php
protected function setUp(): void
{
    parent::setUp();
    
    // Configuración específica del test
    $this->admin = User::factory()->create(['rol' => 'Administrador']);
}
```

## Troubleshooting

### Errores Comunes

1. **"Database not found"**
   ```bash
   php artisan config:clear
   php artisan test
   ```

2. **"Class not found"**
   ```bash
   composer dump-autoload
   ```

3. **"Migration errors"**
   - Verificar que `RefreshDatabase` esté en uso
   - Revisar migraciones pendientes

4. **"Factory errors"**
   - Verificar que las factories estén registradas
   - Comprobar relaciones en factories

### Debug de Tests
```php
// Imprimir respuesta completa
dd($response->getContent());

// Ver errores de validación
dd($response->getSession()->get('errors'));

// Inspeccionar base de datos
$this->assertDatabaseHas('users', ['email' => 'test@example.com']);
$this->assertDatabaseCount('users', 1);
```

## Contribución

Al agregar nuevas funcionalidades:

1. ✅ Crear tests unitarios para modelos
2. ✅ Crear tests de integración para controladores
3. ✅ Actualizar factories si es necesario
4. ✅ Verificar cobertura de código
5. ✅ Documentar casos especiales

## Recursos Adicionales

- [Laravel Testing Documentation](https://laravel.com/docs/testing)
- [PHPUnit Documentation](https://phpunit.de/documentation.html)
- [Laravel Factories](https://laravel.com/docs/database-testing#model-factories)
- [Spatie Activity Log Testing](https://spatie.be/docs/laravel-activitylog/v4/advanced-usage/testing)
