# Sistema de Gestion de Tienda (Laravel)

Aplicacion web con dos caras:
- Tienda online para clientes.
- Panel de administracion para operacion interna.

## 1. Stack tecnologico
- Backend: Laravel 12
- PHP: 8.2+
- Frontend: Blade + Vite + Tailwind CSS
- Base de datos: MySQL

## 2. Requisitos
- PHP 8.2 o superior
- Composer
- Node.js + npm
- MySQL

## 3. Instalacion local
```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run dev
php artisan serve
```

URL local: `http://127.0.0.1:8000`

## 4. Scripts utiles
Desde `composer.json`:
- `composer run setup`: instala, configura, migra con seed y compila assets.
- `composer run dev`: entorno de desarrollo en Windows (server, queue, vite).
- `composer run test`: ejecuta pruebas.
- `composer run reset`: reinicia base de datos con seed.
- `composer run doctor`: limpieza y estado de migraciones.

## 5. Credenciales admin (seed)
- Super Admin: `superadmin@tienda.local` / `password`
- Admin: `admin@tienda.local` / `password`

## 6. Modulos implementados
### Tienda
- Home de tienda.
- Catalogo con filtros, categoria, detalle y busqueda.
- Carrito (agregar, actualizar, eliminar, limpiar).
- Checkout en pasos (envio, pago, confirmacion).
- Validacion de stock antes de procesar pedido.
- Area de cliente (`/tienda/mi-cuenta`) con perfil y pedidos.

### Administracion
- Login y dashboard admin.
- CRUD de productos, zonas, categorias y proveedores.
- CRUD de diccionario catalogo (`/admin/diccionario`).
- Modulo de guardias con:
- Alta y edicion.
- Baja logica y reactivacion.
- Asignacion y devolucion de items.
- Validaciones por tipo de documento y cedula/documento.
- Gestion de usuarios admin (restringido por rol).

### Inventario y compras (modelo de datos)
- Ordenes de compra y sus items.
- Recepciones de compra y detalle.
- Movimientos de inventario y tipos de movimiento.
- Transferencias de inventario entre zonas.
- Ajustes de stock y sus items.
- Relacion proveedores-productos.

## 7. Avances recientes (lo ya hecho)
- Integracion completa del modulo de guardias en rutas, controladores y vistas.
- Integracion de campo `cedula`/documento con validaciones en guardias.
- Normalizacion de codigos de catalogo en migraciones (`normalize_catalog_codes`).
- Incorporacion de modulo `diccionario` para catalogos reutilizables.
- Flujo de checkout conectado con servicios (`CheckoutService`, `PaymentService`).
- Ajustes de vistas y CSS recientes en frontend.

## 8. Rutas principales
### Tienda
- `GET /tienda`
- `GET /tienda/catalogo`
- `GET /tienda/producto/{product}`
- `GET /tienda/carrito`
- `GET /tienda/api/carrito`
- `GET /tienda/checkout`
- `GET /tienda/mi-cuenta`

### Admin
- `GET /admin/login`
- `GET /admin/dashboard`
- `GET /admin/productos`
- `GET /admin/categorias`
- `GET /admin/zonas`
- `GET /admin/proveedores`
- `GET /admin/diccionario`
- `GET /admin/guardias`
- `POST /admin/guardias/{guardia}/items`
- `PATCH /admin/guardias/{id}/reactivar`
- `DELETE /admin/guardia-items/{id}`

## 9. Troubleshooting
Limpiar caches:
```bash
php artisan optimize:clear
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

Si faltan estilos:
```bash
npm run build
```

Reset de password admin (ejemplo):
```bash
php artisan tinker
$user = \App\Models\User::where('email', 'superadmin@tienda.local')->first();
$user->update(['password' => \Illuminate\Support\Facades\Hash::make('newpassword')]);
```

## 10. Proximos pasos sugeridos
- Pasarela de pagos real (Stripe/PayPal).
- Reportes de ventas e inventario.
- Exportacion a Excel/PDF.
- Mayor cobertura de pruebas automatizadas.
