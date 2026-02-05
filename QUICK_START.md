# 🚀 Quick Start Guide - Sistema de Gestión de Tienda

## ⚡ Inicio Rápido en 5 Minutos

### Paso 1: Preparar la Base de Datos
```bash
# Ejecutar migraciones
php artisan migrate

# Cargar datos de demostración (OPCIONAL)
php artisan migrate --seed
```

### Paso 2: Compilar Assets
```bash
# Para desarrollo
npm run dev

# O para producción
npm run build
```

### Paso 3: Iniciar el Servidor
```bash
php artisan serve
```

### Paso 4: Acceder
Abre tu navegador en: **http://localhost:8000**

---

## 📋 Primeros Pasos en la Aplicación

### Si NO ejecutaste `--seed`:
1. **Dashboard**: Verá el mensaje de bienvenida
2. Haz clic en **"1️⃣ Crear Primera Zona"**
3. Luego crea una categoría
4. Finalmente, crea un producto

### Si ejecutaste `--seed`:
1. El dashboard mostrará datos de demostración
2. Puedes explorar productos, categorías y zonas
3. Intenta buscar, editar y eliminar

---

## 🎯 Funciones Principales

### 📊 Dashboard
- Ver estadísticas en tiempo real
- Acceso rápido a crear nuevos registros
- Vista de productos recientes

### 📦 Productos
- ➕ Crear nuevo producto
- 🔍 Buscar productos en tiempo real
- 📝 Ver, editar, eliminar
- 💰 Gestionar precio y stock

### 🏷️ Categorías  
- Organizar productos por categoría
- Asociar a zonas
- Ver productos de cada categoría

### 📍 Zonas
- Estructurar el almacén
- Agrupar categorías
- Ver estadísticas por zona

---

## 🔐 Validaciones Automáticas

El sistema valida automáticamente:
- ✅ Código de barras único
- ✅ Campos obligatorios
- ✅ Formato de datos
- ✅ Relaciones existentes

---

## 💡 Tips Útiles

### Auto-completado de SKU
Al crear producto:
1. Ingresa código de barras
2. El SKU se completa automáticamente como `SKU-{barcode}`

### Búsqueda en Tiempo Real
- En Productos: busca por nombre, código, categoría
- En Categorías: busca por nombre
- Sin necesidad de recargar la página

### Indicadores de Stock
- 🟢 **Verde**: Stock normal
- 🟡 **Amarillo**: Stock bajo (< 20)
- 🔴 **Rojo**: Stock crítico (< 5)

### Acciones Rápidas
Desde el dashboard:
- Botón **Nueva...** para crear registros
- Botón **Ver** para detalles
- Botón **Editar** para modificar

---

## 🎨 Estructura Visual

```
┌─ Sidebar (Navegación) ─────────────────────────┐
│ 🏠 Dashboard                                    │
│ 📦 Productos                                    │
│ 🏷️ Categorías                                   │
│ 📍 Zonas                                        │
└──────────────────────────────────────────────┘
┌─ Topbar (Usuario) ─────────────────────────────┐
│ 📊 Sistema de Gestión de Tienda          [👤]  │
└──────────────────────────────────────────────┘
┌─ Content Area ─────────────────────────────────┐
│                                                  │
│ (Contenido de cada sección)                    │
│                                                  │
└──────────────────────────────────────────────┘
```

---

## 📱 Funciona En

- ✅ Chrome / Firefox / Safari
- ✅ Tablets
- ✅ Teléfonos (interfaz adaptada)

---

## 🆘 Si Algo No Funciona

### 1. Página en blanco
```bash
php artisan cache:clear
php artisan config:clear
npm run build
```

### 2. Base de datos vacía
```bash
php artisan migrate
```

### 3. Estilos no se ven
```bash
npm run build
```

### 4. Error de permisos (Linux/Mac)
```bash
chmod -R 775 storage bootstrap/cache
```

---

## 📚 Documentación Completa

Para más detalles, ver:
- [FRONTEND_GUIDE.md](./FRONTEND_GUIDE.md) - Guía completa
- [FRONTEND_SUMMARY.md](./FRONTEND_SUMMARY.md) - Resumen de cambios

---

## 🎉 ¡Listo!

Tu sistema de gestión de tienda está **100% operativo** y listo para usar.

### Próximos Pasos (Opcionales)
- 🎨 Personalizar colores en el layout
- 📱 Agregar autenticación de usuarios
- 📊 Agregar más reportes
- 🔔 Agregar notificaciones
- 💾 Implementar exportación de datos

---

**¡Que disfrutes usando tu sistema! 🚀**
