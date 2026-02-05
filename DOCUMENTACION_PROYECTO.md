# Documentacion del Proyecto - Practica Tienda (Laravel)

## 1. Resumen Ejecutivo
Este proyecto es una aplicacion web de tienda con dos caras:
1) Tienda online (clientes): catalogo, carrito, checkout y cuenta del cliente.
2) Administracion (backoffice): productos, categorias y zonas de inventario.

El objetivo es permitir publicar productos, gestionar stock y procesar pedidos
simulados con un flujo completo de compra.

---

## 2. Stack Tecnologico
- Backend: Laravel (PHP)
- Frontend: Blade + CSS embebido en vistas
- Base de datos: MySQL (por config en .env)
- Sesiones: Database (SESSION_DRIVER=database)
- Compilacion de assets: Vite / npm

---

## 3. Estructura General del Proyecto

### 3.1 Rutas principales
Archivo: `routes/web.php`

Publico (tienda):
- `GET /tienda` -> home
- `GET /tienda/catalogo` -> catalogo con filtros
- `GET /tienda/categoria/{category}`
- `GET /tienda/producto/{product}`
- `GET /tienda/buscar`
- Carrito: `GET /tienda/carrito`, `POST /tienda/carrito/agregar`, etc.

Auth cliente:
- `GET/POST /tienda/login`
- `GET/POST /tienda/registro`
- `POST /tienda/logout`

Cuenta cliente (requiere login + rol customer):
- `GET /tienda/mi-cuenta`
- `GET /tienda/mi-cuenta/pedidos`
- `GET /tienda/mi-cuenta/pedidos/{order}`
- `GET/PUT /tienda/mi-cuenta/perfil`

Checkout (requiere login + rol customer):
- `GET /tienda/checkout`
- `POST /tienda/checkout/envio`
- `GET /tienda/checkout/pago`
- `POST /tienda/checkout/procesar`
- `GET /tienda/checkout/confirmacion/{order}`

Admin (sin middleware admin aun, ver TODO):
- `/admin/dashboard`
- Recursos: productos, categorias, zonas

### 3.2 Controladores clave
Archivo: `app/Http/Controllers`

- `ShopController`: home, catalogo, categorias, producto, busqueda
- `CartController`: operaciones de carrito (add, update, remove)
- `CheckoutController`: flujo de checkout, calculo de totales, confirmacion
- `CustomerAuthController`: login/registro de clientes
- `CustomerAccountController`: perfil y pedidos
- `ProductController`, `CategoryController`, `ZoneController`: CRUD admin
- `DashboardController`: metricas admin

---

## 4. Modulos Funcionales

### 4.1 Tienda (Shop)
Archivos de vistas: `resources/views/shop/*`

Funciones:
- Pagina de inicio con productos destacados
- Catalogo con filtros y ordenamiento
- Detalle de producto con stock y relacionados
- Busqueda por nombre, descripcion, barcode, sku

### 4.2 Carrito
Servicio: `app/Services/CartService.php`
Controlador: `app/Http/Controllers/Shop/CartController.php`

Logica:
- Carrito asociado a usuario o a session_id
- Items con cantidad y precio unitario
- Subtotal calculado por sumatoria de items

### 4.3 Checkout
Servicio: `app/Services/CheckoutService.php`
Controlador: `app/Http/Controllers/Shop/CheckoutController.php`

Flujo:
1) Validacion de stock
2) Captura de direccion de envio
3) Calculo de totales (IVA 15% Ecuador)
4) Creacion de orden (SalesOrder + SalesOrderItems)
5) Pago simulado (PaymentService)
6) Reserva y descuento de stock
7) Confirmacion final

### 4.4 Cuenta del Cliente
Controlador: `CustomerAccountController`

Funciones:
- Historial de pedidos
- Detalle de pedido
- Perfil (telefono, direccion, canton/ciudad, codigo postal, documento)

### 4.5 Administracion
Vistas: `resources/views/products/*`, `categories/*`, `zones/*`, `dashboard.blade.php`

Funciones:
- CRUD de productos con stock
- CRUD de categorias y zonas
- Dashboard con estadisticas

---

## 5. Modelo de Datos (Relaciones principales)

### Productos / Categorias / Zonas
- Zone 1..N Category
- Category 1..N Product

Archivos:
- `app/Models/Zone.php`
- `app/Models/Category.php`
- `app/Models/Product.php`

### Carrito
- Cart 1..N CartItem
- CartItem N..1 Product

Archivos:
- `app/Models/Cart.php`
- `app/Models/CartItem.php`

### Ordenes de Venta
- SalesOrder 1..N SalesOrderItem
- SalesOrder N..1 User

Archivos:
- `app/Models/SalesOrder.php`
- `app/Models/SalesOrderItem.php`
- `app/Models/SalesOrderPayment.php`

Nota: existen modelos adicionales de inventario (PurchaseOrder, InventoryTransfer, etc)
pero no tienen controladores UI actualmente. Estan listos para evolucion futura.

---

## 6. Seguridad y Roles

Middlewares:
- `EnsureUserIsCustomer`
- `EnsureUserIsAdmin`

Usuarios:
- Roles en tabla pivote `user_role`
- User::isCustomer() y User::isAdmin()

Pendiente:
- En `routes/web.php` el admin aun no tiene middleware admin activo (TODO).

---

## 7. Configuracion y Entorno

Archivos:
- `.env`: variables de entorno
- `config/app.php`: timezone configurado via `APP_TIMEZONE`

Recomendado:
- `APP_TIMEZONE=America/Guayaquil`
- Moneda: USD, formato $1.234,00 (frontend)

---

## 8. Pagos

Servicio: `app/Services/PaymentService.php`
- Pago simulado
- Crea un registro de pago con referencia `SIM-xxxx`
- En produccion se reemplaza por integracion real (Stripe / PayPal)

---

## 9. Comandos Basicos

Migraciones:
```
php artisan migrate
```

Seeders:
```
php artisan db:seed
```

Assets:
```
npm run dev
npm run build
```

Servidor local:
```
php artisan serve
```

---

## 10. Flujo de Compra (resumen corto)
1) Cliente agrega productos al carrito
2) Valida stock en checkout
3) Registra direccion
4) Paga (simulado)
5) Se crea pedido y se descuenta stock
6) Cliente ve confirmacion y puede revisar en "Mis pedidos"

---

## 11. Limitaciones actuales
- Pagos reales no implementados
- Admin sin middleware de acceso
- Algunos textos tienen errores de codificacion (caracteres raros)
- Parte del modulo de inventario no tiene interfaz aun

---

## 12. Roadmap sugerido
- Activar middleware admin
- Integrar pasarela real de pagos
- Normalizar codificacion UTF-8 en vistas y docs
- Completar modulo de inventario (compras, transferencias, ajustes)
- Reportes y exportaciones

