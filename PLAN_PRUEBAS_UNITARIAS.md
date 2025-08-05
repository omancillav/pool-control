# Plan de Pruebas Unitarias - Pool Control

## 📋 Información General

**Proyecto:** Pool Control - Sistema de Gestión de Albercas  
**Framework:** Laravel 12  
**Herramienta de Testing:** PHPUnit  
**Fecha:** Agosto 2025  
**Versión:** 1.0

---

## 🎯 Objetivos

### Objetivo Principal

Garantizar la calidad, funcionalidad y seguridad del sistema Pool Control mediante pruebas automatizadas exhaustivas.

### Objetivos Específicos

- Validar el comportamiento correcto de modelos y relaciones
- Verificar la autenticación y autorización por roles
- Comprobar el funcionamiento de controladores CRUD
- Asegurar la integridad del middleware de seguridad
- Confirmar el registro de actividades (logs)

---

## 🏗️ Estructura de Pruebas

### Tests Unitarios (`tests/Unit/`)

Prueban componentes individuales de forma aislada:

#### **UserModelTest.php**

- ✅ Creación de usuarios
- ✅ Atributos fillables y hidden
- ✅ Relaciones con membresías y clases
- ✅ Validación de roles

#### **MembresiaModelTest.php**

- ✅ Creación y validación de membresías
- ✅ Relaciones con usuarios
- ✅ Atributos y reglas de negocio

#### **ClaseModelTest.php**

- ✅ Gestión de clases
- ✅ Relaciones con usuarios y profesores
- ✅ Validación de fechas y horarios

#### **RelationshipsTest.php**

- ✅ Relaciones User-Membresia
- ✅ Relaciones User-Clase
- ✅ Integridad referencial

### Tests de Integración (`tests/Feature/`)

Prueban el comportamiento completo del sistema:

#### **AuthenticationTest.php**

- ✅ Login con credenciales válidas
- ✅ Rechazo de credenciales inválidas
- ✅ Registro de nuevos usuarios
- ✅ Logout de usuarios
- ✅ Autenticación OAuth (Google/Facebook)

#### **RoleMiddlewareTest.php**

- ✅ Acceso de administradores
- ✅ Acceso de profesores
- ✅ Acceso de clientes
- ✅ Restricciones por rol
- ✅ Redirección de usuarios no autorizados

#### **UserControllerTest.php**

- ✅ CRUD completo de usuarios
- ✅ Validaciones de formularios
- ✅ Autorización por rol
- ✅ Hash de contraseñas

#### **MembresiaControllerTest.php**

- ✅ Gestión de membresías
- ✅ Listado por rol
- ✅ Validaciones de datos

#### **ClaseControllerTest.php**

- ✅ Administración de clases
- ✅ Asignación de profesores
- ✅ Control de acceso

#### **ActivityLogTest.php**

- ✅ Registro de actividades
- ✅ Información de usuarios
- ✅ Eventos del sistema

---

## 🔧 Configuración del Entorno

### Base de Datos de Testing

```php
// phpunit.xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

### Factories Utilizadas

- **UserFactory**: Genera usuarios con diferentes roles
- **MembresiaFactory**: Crea membresías de prueba
- **ClaseFactory**: Genera clases con datos realistas

---

## 📊 Casos de Prueba por Módulo

### 1. **Autenticación y Seguridad**

| Caso     | Descripción                       | Estado |
| -------- | --------------------------------- | ------ |
| AUTH-001 | Login con credenciales válidas    | ✅     |
| AUTH-002 | Rechazo de credenciales inválidas | ✅     |
| AUTH-003 | Registro de usuarios nuevos       | ✅     |
| AUTH-004 | Logout de sesión                  | ✅     |
| AUTH-005 | OAuth con Google                  | ✅     |
| AUTH-006 | OAuth con Facebook                | ✅     |
| AUTH-007 | Hash de contraseñas               | ✅     |

### 2. **Control de Roles y Permisos**

| Caso     | Descripción                  | Estado |
| -------- | ---------------------------- | ------ |
| ROLE-001 | Acceso de Administrador      | ✅     |
| ROLE-002 | Acceso de Profesor           | ✅     |
| ROLE-003 | Acceso de Cliente            | ✅     |
| ROLE-004 | Restricción de rutas por rol | ✅     |
| ROLE-005 | Redirección no autorizada    | ✅     |

### 3. **Modelos y Relaciones**

| Caso      | Descripción             | Estado |
| --------- | ----------------------- | ------ |
| MODEL-001 | Creación de usuarios    | ✅     |
| MODEL-002 | Relación User-Membresia | ✅     |
| MODEL-003 | Relación User-Clase     | ✅     |
| MODEL-004 | Atributos fillables     | ✅     |
| MODEL-005 | Atributos hidden        | ✅     |

### 4. **Operaciones CRUD**

| Caso     | Descripción         | Estado |
| -------- | ------------------- | ------ |
| CRUD-001 | Crear usuarios      | ✅     |
| CRUD-002 | Leer usuarios       | ✅     |
| CRUD-003 | Actualizar usuarios | ✅     |
| CRUD-004 | Eliminar usuarios   | ✅     |
| CRUD-005 | CRUD Membresías     | ✅     |
| CRUD-006 | CRUD Clases         | ✅     |

### 5. **Validaciones**

| Caso      | Descripción                  | Estado |
| --------- | ---------------------------- | ------ |
| VALID-001 | Validación email único       | ✅     |
| VALID-002 | Validación campos requeridos | ✅     |
| VALID-003 | Validación formato datos     | ✅     |
| VALID-004 | Validación reglas negocio    | ✅     |

### 6. **Logs y Auditoría**

| Caso    | Descripción               | Estado |
| ------- | ------------------------- | ------ |
| LOG-001 | Registro de creación      | ✅     |
| LOG-002 | Registro de actualización | ✅     |
| LOG-003 | Registro de eliminación   | ✅     |
| LOG-004 | Información de usuario    | ✅     |

---

## 🚀 Comandos de Ejecución

### Ejecución Completa

```bash
# Todos los tests
composer test
php artisan test

# Con cobertura
composer test-coverage
php artisan test --coverage
```

### Ejecución Selectiva

```bash
# Solo tests unitarios
composer test-unit
php artisan test tests/Unit

# Solo tests de integración
composer test-feature
php artisan test tests/Feature

# Test específico
php artisan test tests/Unit/UserModelTest.php
```

### Filtros y Grupos

```bash
# Por método específico
php artisan test --filter=user_can_login

# Por grupo
php artisan test --group=authentication
```

---

## 📈 Métricas y Cobertura

### Objetivos de Cobertura

- **Modelos**: 95% mínimo
- **Controladores**: 90% mínimo
- **Middleware**: 85% mínimo
- **Cobertura General**: 85% mínimo

### Reportes

- **HTML**: `composer test-coverage-html`
- **Consola**: `php artisan test --coverage`
- **CI/CD**: GitHub Actions automático

---

## 🔄 Integración Continua

### GitHub Actions

- Ejecución automática en cada push
- Múltiples versiones de PHP
- Matriz de bases de datos
- Reportes de cobertura

### Flujo de Testing

1. **Desarrollo Local**: Tests antes de commit
2. **Pull Request**: Validación automática
3. **Merge**: Tests completos en main
4. **Deploy**: Tests de regresión

---

## 🎯 Conclusiones

### Estado Actual

- ✅ **15/19 funcionalidades** cubiertas con tests
- ✅ **Cobertura superior al 80%** en componentes críticos
- ✅ **Pipeline CI/CD** funcional
- ✅ **Tests automatizados** ejecutándose correctamente

### Fortalezas

- Cobertura completa de autenticación
- Tests exhaustivos de roles y permisos
- Validación de modelos y relaciones
- Integración con factories realistas

### Próximos Pasos

1. Implementar tests para middleware de inactividad
2. Añadir tests para validaciones frontend
3. Crear tests de integración HTTPS
4. Documentar casos edge adicionales

---

**Nota**: Este plan se actualiza continuamente conforme se implementan nuevas funcionalidades en el sistema Pool Control.
