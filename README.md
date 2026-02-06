# Sistema de Gestión de Tienda (Laravel)

Documentación única y unificada del proyecto.

## 1. Resumen
Aplicación web con dos caras:
1. Tienda online (clientes): catálogo, carrito, checkout y cuenta.
2. Administración (backoffice): productos, categorías, zonas, proveedores y usuarios.

El objetivo es publicar productos, gestionar stock y procesar pedidos con un flujo de compra completo.

## 2. Stack tecnológico
- Backend: Laravel 11 (PHP 8.2+)
- Frontend: Blade + CSS embebido en vistas
- Base de datos: MySQL
- Assets: Vite / npm

## 3. Instalación y arranque (local)
1. Instalar dependencias:
```bash
composer install
npm install
```

2. Configurar entorno:
```bash
cp .env.example .env
php artisan key:generate
```

3. Migraciones y datos:
```bash
php artisan migrate
php artisan db:seed
```

4. Assets:
```bash
npm run dev
# o
npm run build
```

5. Levantar servidor:
```bash
php artisan serve
```

Acceso local: `http://localhost:8000`

## 4. Docker (local)
Si usas docker-compose, el panel corre en:
- `http://localhost:8080`

Comandos típicos:
```bash
docker compose up -d --build
docker compose exec app php artisan migrate --seed
```

## 5. Credenciales admin (seed)
Se crean con `php artisan migrate --seed` o `php artisan db:seed`.

Super Admin:
- Email: `superadmin@tienda.local`
- Contraseña: `password`

Admin:
- Email: `admin@tienda.local`
- Contraseña: `password`

URL de login admin:
- `http://localhost:8080/admin/login` (Docker)
- `http://localhost:8000/admin/login` (local)

## 6. Módulos principales
### Administración
- Dashboard: estadísticas de productos, categorías y zonas
- Productos: CRUD completo, stock y estados
- Categorías: CRUD y relación con zonas
- Zonas: CRUD y relación con categorías
- Proveedores: CRUD completo
- Usuarios: solo Super Admin

### Tienda
- Home con productos destacados
- Catálogo con filtros y búsqueda
- Detalle de producto con relacionados
- Carrito (actualización de cantidades)
- Checkout con validación de stock
- Cuenta del cliente (perfil y pedidos)

## 7. Roles y seguridad
Roles principales:
- `super_admin`: acceso total, puede gestionar usuarios
- `admin`: productos, categorías, zonas, proveedores
- `customer`: tienda y cuenta

El admin se protege con middleware y validación de rol en login.

## 8. Flujo de compra (resumen)
1. Cliente agrega productos al carrito
2. Checkout valida stock
3. Captura dirección de envío
4. Pago simulado (PaymentService)
5. Se crea pedido y se descuenta stock
6. Confirmación y pedidos en “Mi cuenta”

Nota: IVA configurado al 15% (Ecuador).

## 9. Estructura de datos (relaciones clave)
```
Zone 1..N Category
Category 1..N Product
Cart 1..N CartItem
SalesOrder 1..N SalesOrderItem
User N..N Role
Supplier 1..N PurchaseOrder
```

## 10. Endpoints principales
Tienda:
- `GET /tienda`
- `GET /tienda/catalogo`
- `GET /tienda/producto/{product}`
- `GET /tienda/carrito`

Admin:
- `GET /admin/dashboard`
- `GET /admin/productos`
- `GET /admin/categorias`
- `GET /admin/zonas`
- `GET /admin/proveedores`
- `GET /admin/usuarios` (solo Super Admin)

## 11. Troubleshooting
Página en blanco / errores raros:
```bash
php artisan optimize:clear
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

Assets sin estilos:
```bash
npm run build
```

Reset contraseña (admin):
```bash
php artisan tinker
$user = \App\Models\User::where('email', 'superadmin@tienda.local')->first();
$user->update(['password' => \Illuminate\Support\Facades\Hash::make('newpassword')]);
```

## 12. Demo rápida
1. Entra al admin y crea zona → categoría → producto
2. Abre la tienda y agrega al carrito
3. Completa checkout
4. Revisa pedido en “Mi cuenta”

## 13. Roadmap sugerido
- Pasarela de pagos real (Stripe/PayPal)
- Reportes de ventas e inventario
- Auditoría y logs por acción
- Exportación a Excel/PDF

