# GUÍA DE ADMINISTRACIÓN - SISTEMA DE TIENDA

## 1. ACCESO A LA ADMINISTRACIÓN

### Credenciales Predeterminadas

Después de ejecutar `php artisan migrate:refresh --seed`, se crearán automáticamente dos usuarios admin:

**Super Administrador:**
- **Email:** `superadmin@tienda.local`
- **Contraseña:** `password`
- **Permisos:** Acceso completo a todo el sistema, incluyendo gestión de usuarios

**Administrador:**
- **Email:** `admin@tienda.local`
- **Contraseña:** `password`
- **Permisos:** Gestión de productos, categorías, zonas y proveedores

### URL de Login
```
http://localhost/admin/login
```

---

## 2. ESTRUCTURA DE LA ADMINISTRACIÓN

### Menú Principal (Sidebar)

El menú de administración incluye:

1. **Dashboard** - Visualización de estadísticas generales
2. **Productos** - Gestión completa de productos (CRUD)
3. **Categorías** - Gestión de categorías por zona
4. **Zonas** - Gestión de zonas del almacén
5. **Proveedores** - Gestión de proveedores (NUEVO)
6. **Usuarios** - Gestión de usuarios del sistema (Solo Super Admin)
7. **Ver Tienda** - Enlace a la tienda pública
8. **Cerrar Sesión** - Logout seguro

---

## 3. MÓDULOS IMPLEMENTADOS

### A. GESTIÓN DE USUARIOS (Solo Super Admin)

**URL:** `/admin/usuarios`

#### Funcionalidades:
- Listar todos los usuarios con paginación
- Crear nuevos usuarios asignando roles
- Editar usuarios y sus roles
- Ver detalles completos de cada usuario
- Eliminar usuarios (con validaciones de seguridad)

#### Validaciones:
- No se puede eliminar el usuario actualmente logueado
- No se puede eliminar usuarios con órdenes de venta/compra asociadas
- Emails únicos en el sistema

#### Vista de Detalles:
- Información personal (nombre, email, teléfono)
- Roles asignados
- Cantidad de órdenes de venta y compra
- Historial de últimas órdenes

---

### B. GESTIÓN DE PROVEEDORES (Admin/Super Admin)

**URL:** `/admin/proveedores`

#### Campos Disponibles:
- Código (único)
- Nombre
- Contacto
- Email
- Teléfono
- Dirección
- Ciudad
- Código Postal
- RUC/NIT (para facturación)
- Cuenta Bancaria
- Estado (Activo/Inactivo)

#### Funcionalidades:
- CRUD completo (Crear, Leer, Actualizar, Eliminar)
- Búsqueda por código o nombre
- Paginación de 15 proveedores por página
- Vista detallada con historial de órdenes de compra
- Validación de integridad (no permite eliminar si tiene órdenes)

---

### C. GESTIÓN DE PRODUCTOS

**URL:** `/admin/productos`

#### Campos Disponibles:
- Categoría (required)
- Código de Barras (unique)
- SKU
- Nombre
- Descripción
- Precio
- Cantidad en Stock
- Unidad de Medida (kg, lt, unidad, etc)
- Estado (Activo, Inactivo, Descontinuado)

#### Funcionalidades:
- Búsqueda en tiempo real
- Filtro por estado
- Indicadores visuales de nivel de stock
- Vista detallada con información de categoría y zona
- Control de integridad referencial

---

### D. GESTIÓN DE CATEGORÍAS

**URL:** `/admin/categorias`

#### Campos:
- Zona (required)
- Nombre
- Código
- Descripción

#### Características:
- Asociación automática a zonas
- Vista de productos en cada categoría
- Validación de unicidad (nombre único por zona)

---

### E. GESTIÓN DE ZONAS

**URL:** `/admin/zonas`

#### Campos:
- Código (unique)
- Nombre (unique)
- Descripción

#### Características:
- Visualización de categorías asociadas
- Recuento de productos por zona
- Protección contra eliminación si tiene categorías

---

## 4. CONTROL DE ACCESO Y ROLES

### Sistema de Roles

El sistema implementa dos roles administrativos:

#### Super Admin (`super_admin`)
```php
$user->isSuperAdmin() // Returns true
$user->isAdmin() // Returns true (hereda de super admin)

Permisos:
- Gestión completa de usuarios
- Gestión de productos, categorías, zonas, proveedores
- Acceso a todos los módulos
```

#### Admin (`admin`)
```php
$user->isAdmin() // Returns true
$user->isSuperAdmin() // Returns false

Permisos:
- Gestión de productos, categorías, zonas, proveedores
- NO puede gestionar usuarios
- NO puede ver sección de usuarios
```

### Middleware de Protección

**Todas las rutas admin** están protegidas con:
```php
middleware(['auth', 'admin.or.superadmin'])
```

Las rutas de **usuarios** tienen protección adicional en el controlador:
```php
// Solo permite acceso a Super Admin
if (!$request->user()->isSuperAdmin()) {
    return redirect()->route('admin.dashboard')
        ->with('error', 'No tienes permiso...');
}
```

---

## 5. CARACTERÍSTICAS DE SEGURIDAD

✅ **Autenticación:** Sistema de login seguro con hashing de contraseñas
✅ **Autorización:** Control granular por rol
✅ **Validación:** Validación en cliente y servidor
✅ **CSRF Protection:** Token CSRF en todos los formularios
✅ **Integridad Referencial:** No permite eliminar registros con dependencias
✅ **Auditoría:** Campos `created_at`, `updated_at` en todos los registros
✅ **Límites:** Paginación automática para grandes conjuntos de datos

---

## 6. FLUJOS DE TRABAJO RECOMENDADOS

### Flujo 1: Crear un Usuario Admin

1. Login como Super Admin
2. Ir a `/admin/usuarios`
3. Clic en "+ Nuevo Usuario"
4. Completar formulario
5. Asignar rol "admin"
6. Guardar

### Flujo 2: Agregar un Proveedor

1. Login como Admin
2. Ir a `/admin/proveedores`
3. Clic en "+ Nuevo Proveedor"
4. Completar información
5. Establecer estado "Activo"
6. Guardar

### Flujo 3: Gestionar Productos

1. Login como Admin
2. Ir a `/admin/productos`
3. Crear/Editar productos con:
   - Seleccionar categoría
   - Ingresar código de barras
   - Establecer precio y stock
   - Seleccionar unidad de medida

---

## 7. MENSAJES Y RETROALIMENTACIÓN

El sistema proporciona retroalimentación clara:

### Alertas de Éxito
- Color verde (#d1fae5)
- Se auto-cierran después de 5 segundos
- Ejemplo: "Producto creado correctamente."

### Alertas de Error
- Color rojo (#fee2e2)
- Permanecen hasta cerrarlas
- Muestran validaciones detalladas

### Estados de Registro
- **Activo:** Verde con icono de check
- **Inactivo:** Gris
- **Descontinuado:** Rojo

---

## 8. BASE DE DATOS - RELACIONES

```
Users (1:N) → Sales Orders
         (1:N) → Purchase Orders
         (N:N) → Roles

Suppliers (1:N) → Purchase Orders
       (N:N) → Products

Products (N:1) → Category
       (1:N) → Sales Order Items
       (1:N) → Purchase Order Items

Categories (N:1) → Zones
```

---

## 9. PRÓXIMAS IMPLEMENTACIONES RECOMENDADAS

- [ ] Órdenes de Venta (Sales Orders) - módulo completo
- [ ] Órdenes de Compra (Purchase Orders) - módulo completo
- [ ] Movimientos de Inventario - tracking y auditoría
- [ ] Reportes y Gráficos
- [ ] Exportar a Excel/PDF
- [ ] Copia de seguridad automática
- [ ] Historial de cambios detallado
- [ ] Notificaciones por email

---

## 10. TROUBLESHOOTING

### Problema: "No autorizado" al acceder a `/admin/usuarios`

**Solución:** Solo el Super Admin puede acceder. Verifica que estés logueado como `superadmin@tienda.local`

### Problema: No se puede eliminar un proveedor

**Solución:** El proveedor tiene órdenes de compra asociadas. Primero cambia el estado a "Inactivo" o elimina las órdenes.

### Problema: Error de validación "Código ya existe"

**Solución:** Los códigos deben ser únicos. Cambia el código e intenta nuevamente.

### Problema: Olvide la contraseña

**Solución:** Ejecuta en la terminal:
```bash
php artisan tinker
$user = \App\Models\User::where('email', 'superadmin@tienda.local')->first();
$user->update(['password' => \Illuminate\Support\Facades\Hash::make('newpassword')]);
```

---

**Última actualización:** 5 de Febrero de 2026
**Versión:** 1.0
**Estado:** Producción
