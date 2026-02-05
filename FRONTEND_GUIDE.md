# 🏪 Sistema de Gestión de Tienda

Un completo sistema de gestión de inventario y productos para tiendas, desarrollado con **Laravel 11** y diseño moderno.

## 🎨 Características Principales

### Dashboard Interactivo
- **Estadísticas en Tiempo Real**: Visualiza el total de productos, categorías, zonas y productos con stock bajo
- **Productos Recientes**: Acceso rápido a los últimos productos registrados
- **Vista General de Categorías**: Organización visual de todas las categorías
- **Acciones Rápidas**: Botones de acceso directo para crear nuevos registros

### Gestión de Productos 📦
- **CRUD Completo**: Crear, leer, actualizar y eliminar productos
- **Búsqueda en Tiempo Real**: Filtrado instantáneo de productos
- **Detalles Detallados**: Código de barras, SKU, precio, stock y estado
- **Indicadores de Stock**: Avisos visuales para stock crítico, bajo y disponible
- **Múltiples Estados**: Activo, Inactivo, Descontinuado

### Gestión de Categorías 🏷️
- **Organización por Zonas**: Las categorías se agrupan dentro de zonas específicas
- **Interfaz de Tarjetas**: Visualización atractiva y clara
- **Vista de Productos**: Asociación directa entre categorías y sus productos
- **Búsqueda Integrada**: Encuentra categorías rápidamente

### Gestión de Zonas 📍
- **Estructura Jerárquica**: Zonas contienen categorías que contienen productos
- **Estadísticas**: Visualiza cuántas categorías y productos hay en cada zona
- **Gestión Completa**: CRUD funcional para todas las operaciones

### Diseño Moderno 🎨
- **Interfaz Responsive**: Funciona perfectamente en desktop, tablet y móvil
- **Barra Lateral de Navegación**: Acceso rápido a todas las secciones
- **Colores Gradientes**: Diseño moderno con gradientes atractivos
- **Iconos Intuitivos**: Cada sección usa iconos que facilitan la navegación
- **Animaciones Suaves**: Transiciones y efectos visuales agradables

## 📁 Estructura del Proyecto

```
practica-tienda/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── DashboardController.php      # Dashboard principal
│   │       ├── ProductController.php        # Gestión de productos
│   │       ├── CategoryController.php       # Gestión de categorías
│   │       └── ZoneController.php           # Gestión de zonas
│   └── Models/
│       ├── Product.php
│       ├── Category.php
│       ├── Zone.php
│       └── ... (otros modelos)
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php                # Layout principal
│   │   ├── dashboard.blade.php              # Vista del dashboard
│   │   ├── products/
│   │   │   ├── index.blade.php              # Listado de productos
│   │   │   ├── create.blade.php             # Crear producto
│   │   │   ├── edit.blade.php               # Editar producto
│   │   │   ├── show.blade.php               # Detalle del producto
│   │   │   └── _form.blade.php              # Formulario compartido
│   │   ├── categories/                      # Vistas de categorías
│   │   └── zones/                           # Vistas de zonas
│   ├── css/
│   │   └── app.css                          # Estilos personalizados
│   └── js/
│       └── app.js                           # Scripts principales
├── routes/
│   └── web.php                              # Rutas de la aplicación
└── database/
    ├── migrations/                          # Migraciones de BD
    └── factories/                           # Factories para testing
```

## 🚀 Instalación y Configuración

### Requisitos Previos
- PHP 8.2 o superior
- Composer
- MySQL/SQLite
- Node.js (para Vite)

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
cd practica-tienda
```

2. **Instalar dependencias PHP**
```bash
composer install
```

3. **Instalar dependencias Node.js**
```bash
npm install
```

4. **Configurar ambiente**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configurar base de datos**
- Editar `.env` con tus credenciales de BD
- Crear una nueva BD MySQL/SQLite

6. **Ejecutar migraciones**
```bash
php artisan migrate
```

7. **Compilar assets (CSS/JS)**
```bash
npm run build
# O para desarrollo con hot-reload:
npm run dev
```

8. **Iniciar servidor**
```bash
php artisan serve
```

Abre tu navegador en `http://localhost:8000`

## 📊 Uso del Sistema

### Dashboard
- Acceso inmediato al dashboard con estadísticas clave
- Visualiza productos, categorías y zonas en tiempo real
- Botones de acceso rápido para crear nuevos registros

### Crear un Producto
1. Navega a **Productos** → **Nuevo Producto**
2. Completa los campos obligatorios:
   - Categoría (debe existir una zona y categoría)
   - Código de Barras (único)
   - Nombre del Producto
   - Cantidad en Stock
   - Unidad de Medida
   - Estado (Activo/Inactivo/Descontinuado)
3. Opcionalmente, añade:
   - SKU (se auto-completa con formato SKU-{barcode})
   - Descripción
   - Precio

### Crear una Categoría
1. Navega a **Categorías** → **Nueva Categoría**
2. Completa:
   - Zona (relación padre)
   - Nombre de la Categoría
   - Código (opcional)
   - Descripción (opcional)

### Crear una Zona
1. Navega a **Zonas** → **Nueva Zona**
2. Completa:
   - Código de Zona (único)
   - Nombre
   - Descripción (opcional)

## 🎯 Funcionalidades Especiales

### Búsqueda en Tiempo Real
- Busca instantáneamente en listados de productos
- Filtra por nombre, código, categoría y zona
- Sin necesidad de recargar la página

### Indicadores Visuales
- **Verde (Success)**: Stock normal, categorías activas
- **Amarillo (Warning)**: Stock bajo (< 20 unidades)
- **Rojo (Danger)**: Stock crítico (< 5 unidades)

### Confirmaciones de Eliminación
- Se pide confirmación antes de eliminar registros
- Protección contra eliminación accidental
- Mensajes claros sobre las consecuencias

### Validación de Datos
- Validación del lado del servidor
- Mensajes de error claros
- Prevención de duplicados (código de barras único)

## 🗺️ Relaciones de Datos

```
Zona (1)
├── Categoría (N)
    ├── Producto (N)
    │   ├── Precio
    │   ├── Stock
    │   └── Estado
```

**Jerarquía:**
- Una zona contiene múltiples categorías
- Una categoría contiene múltiples productos
- Cada zona/categoría/producto es único

## 🎨 Colores y Temas

### Paleta de Colores
- **Principal**: Gradiente morado (#667eea → #764ba2)
- **Éxito**: Verde (#10b981)
- **Advertencia**: Amarillo (#f59e0b)
- **Peligro**: Rojo (#ef4444)
- **Fondo**: Gris claro (#f3f4f6)

### Elementos de Interfaz
- Sidebar oscuro para navegación
- Topbar blanca con información del usuario
- Cards con bordes izquierdos coloreados
- Botones con efectos hover y transiciones

## 📱 Responsive Design

El sistema es completamente responsive:
- **Desktop**: Layout completo con sidebar
- **Tablet**: Sidebar colapsable, layout ajustado
- **Móvil**: Interfaz optimizada, elementos apilados

## 🔒 Seguridad

- **CSRF Protection**: Tokens de seguridad en formularios
- **SQL Injection Protection**: Consultas parametrizadas
- **XSS Protection**: Escapado de datos en vistas
- **Validación de Entrada**: Validación en servidor

## 🐛 Troubleshooting

### La página no carga bien
```bash
# Reconstruir assets
npm run build

# Limpiar caché
php artisan cache:clear
php artisan config:clear
```

### Base de datos vacía
```bash
# Ejecutar migraciones
php artisan migrate

# Opcionalmente, crear datos de prueba
php artisan db:seed
```

### Permisos de archivos
```bash
# Linux/Mac
chmod -R 775 storage bootstrap/cache

# Windows - Asegurar permisos de escritura en storage/
```

## 📚 Modelos Disponibles

El sistema incluye modelos para:
- `Product` - Productos
- `Category` - Categorías
- `Zone` - Zonas
- `User` - Usuarios (base)
- Y más... (ver `app/Models/`)

## 🔗 Endpoints Principales

| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/dashboard` | Dashboard principal |
| GET | `/productos` | Listado de productos |
| GET | `/productos/create` | Crear producto |
| POST | `/productos` | Guardar producto |
| GET | `/productos/{id}` | Ver detalle |
| GET | `/productos/{id}/edit` | Editar producto |
| PUT | `/productos/{id}` | Actualizar |
| DELETE | `/productos/{id}` | Eliminar |
| GET | `/categorias` | Listado de categorías |
| GET | `/zonas` | Listado de zonas |

## 💡 Tips Útiles

1. **Auto-completado de SKU**: Al llenar el código de barras en crear producto, el SKU se auto-completa
2. **Búsqueda rápida**: Usa la barra de búsqueda en listados para filtrar al instante
3. **Stock crítico**: Los productos con < 5 unidades se marcan en rojo
4. **Navegación rápida**: Usa los botones de la barra lateral para navegar

## 📝 Notas de Desarrollo

- El proyecto usa **Laravel Blade** para templates
- Estilos CSS vanila (sin framework, pero responsive)
- JavaScript vanila para interactividad
- Vite para bundling de assets
- Compatible con Tailwind CSS (si se desea agregar)

## 🚢 Deployment

Para producción:
```bash
# Compilar assets para producción
npm run build

# Optimizar autoloader
composer install --optimize-autoloader --no-dev

# Cachear configuración
php artisan config:cache
php artisan route:cache
```

## 📞 Soporte

Si tienes problemas:
1. Revisa los logs en `storage/logs/`
2. Verifica que la BD esté configurada correctamente
3. Asegúrate de tener todas las dependencias instaladas
4. Ejecuta `php artisan tinker` para debug

## 📄 Licencia

Este proyecto es para fines educativos.

---

**¡Disfruta usando tu sistema de gestión de tienda!** 🎉
