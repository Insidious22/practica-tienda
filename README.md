# Sistema de Gestion de Tienda (Laravel)

Aplicacion web con dos caras:
- Tienda online para clientes.
- Panel de administracion para operacion interna.

## 1. Stack tecnologico
- Backend: Laravel 12
- PHP: 8.2+
- Frontend: Blade + Vite + Turbo (Hotwire)
- Base de datos: MySQL
- Exportacion: Laravel Excel (Maatwebsite) para CSV/XLSX
- Contenedores: Docker (app, web, db, node)

## 2. Requisitos
- Docker y Docker Compose (recomendado)
- Opcion local sin Docker:
  - PHP 8.2 o superior
  - Composer
  - Node.js + npm
  - MySQL
  - Extensiones PHP: `zip`, `xml`, `mbstring`

## 3. Instalacion y ejecucion

### Opcion A: Docker (recomendada)
```bash
docker compose up -d --build
docker compose exec app composer install
docker compose exec app cp .env.example .env
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
docker compose exec node npm install
docker compose exec node npm run dev
```

URL web: `http://localhost:8080`

### Opcion B: Local (sin Docker)
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
- `composer run dev`: entorno de desarrollo.
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
- Modulo de guardias con alta, edicion, baja logica, reactivacion y asignacion/devolucion de items.
- Gestion de usuarios admin por rol.
- Exportacion de datos CSV/XLSX con filtro por fechas.

## 7. Cambios recientes (Turbo SPA y UX)

### Navegacion sin recarga completa
- Se integro Turbo para navegacion parcial en tienda y admin.
- Listados de catalogo, categoria y busqueda actualizan contenido con `turbo-frame` en lugar de recargar pagina completa.
- Se agrego paginacion manual por frame con `data-turbo-frame` y `data-turbo-action="advance"`.

### Estados de carga visual
- Skeleton loaders en:
  - Catalogo tienda
  - Categoria tienda
  - Busqueda tienda
  - Listados admin (usuarios, proveedores, diccionario, guardias)
- Se uso estado `frame[busy]` para mostrar carga de forma no intrusiva.

### Mejoras de estabilidad
- Guard contra listeners duplicados en auto-submit de filtros.
- Ajustes de target (`_top`) en enlaces/formularios que salen de frames.
- Paginacion en `GuardiaController@index` para evitar listas completas.

## 8. Rutas principales

### Tienda
- `GET /tienda`
- `GET /tienda/catalogo`
- `GET /tienda/categoria/{category}`
- `GET /tienda/producto/{product}`
- `GET /tienda/buscar`
- `GET /tienda/carrito`
- `GET /tienda/api/carrito`
- `GET /tienda/checkout`
- `GET /tienda/mi-cuenta`

### Admin
- `GET /admin/login`
- `GET /admin/dashboard`
- `GET /admin/exportar`
- `GET /admin/productos`
- `GET /admin/categorias`
- `GET /admin/zonas`
- `GET /admin/proveedores`
- `GET /admin/diccionario`
- `GET /admin/guardias`
- `GET /admin/usuarios`

### Rutas Turbo
- `routes/turbo.php` contiene endpoints de contenido parcial para flujos Turbo.

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

En Docker:
```bash
docker compose exec node npm run build
docker compose restart web app
```

## 10. Notas de produccion
- No subir artefactos temporales en `storage/` (dumps `.html/.css/.js/.tmp`).
- Se agrego `.dockerignore` para evitar incluir archivos temporales, logs, cache y docs en la imagen.
- Se reforzo `.gitignore` para ignorar temporales de `storage`.
- Dockerfile de produccion instala `libzip-dev` para compilar correctamente la extension `zip` en PHP.

### Arquitectura prod actual (Docker)
- `app` (`tienda_app`): Laravel + PHP-FPM, compila/contiene `public/build` (Vite).
- `web` (`tienda_web`): Nginx expuesto en puerto `80`.
- `db` (`tienda_db`): MySQL.
- Volumen compartido `public_build`: sincroniza los assets de Vite entre `app` y `web`.

Importante:
- `web` monta `./public` en solo lectura y ademas monta `public_build` sobre `./public/build`.
- `app` copia `public/build` al volumen compartido al iniciar.
- Esto evita desincronizacion de hashes Vite entre el contenedor `app` y lo que sirve Nginx.

### Deploy y rollback (VPS)
Comandos disponibles en el servidor:
- `sudo tienda-deploy`: despliegue completo (pull, build, restart, clear cache, verificacion de assets Vite).
- `sudo tienda-rollback <commit|tag|branch>`: rollback a una revision especifica + redeploy.
- `sudo tienda-rollback-last`: rollback rapido al deploy anterior (`HEAD~1`) + redeploy.

Flujo recomendado:
```bash
ssh deploy@TU_IP
sudo tienda-deploy
```

Rollback rapido si algo falla:
```bash
ssh deploy@TU_IP
sudo tienda-rollback-last
```

### Scripts versionados (repo)
- `scripts/deploy_prod.sh`: flujo de despliegue de produccion con verificacion.
- `scripts/rollback_prod.sh`: rollback de produccion a un commit/tag/rama y redeploy.

### Verificacion de estilos en produccion
El deploy valida automaticamente que:
- La tienda NO renderice Bootstrap CDN.
- La tienda SI renderice assets Vite (`/build/assets/...`).
- Los assets CSS/JS referenciados respondan `200`.

## 11. Proximos pasos sugeridos
- Completar el patron Turbo en todos los listados admin restantes.
- Incrementar pruebas automatizadas de navegacion Turbo y regresion visual.
- Agregar monitoreo de rendimiento (TTFB, navegacion parcial, errores JS).
- Evaluar cache por fragmentos para vistas de alto trafico.
