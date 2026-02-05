# Guia de Presentacion y Preguntas Frecuentes

## 1. Elevator Pitch (30-60 segundos)
Este proyecto es una tienda web desarrollada en Laravel con dos modulos:
una tienda online para clientes y un panel de administracion para gestionar
productos, categorias, zonas y stock. El flujo de compra es completo
carrito -> checkout -> pago simulado -> confirmacion y registro de pedidos.

---

## 2. Lo que puedes mostrar en demo
1) Dashboard admin con estadisticas
2) CRUD de productos (crear, editar, eliminar)
3) Catalogo publico y filtros
4) Carrito con cantidades y subtotal
5) Checkout con IVA Ecuador 15% y confirmacion
6) Historial de pedidos en "Mi cuenta"

---

## 3. Arquitectura en 5 puntos
1) Laravel MVC: Controladores + Modelos Eloquent + Vistas Blade
2) Servicios: CartService, CheckoutService, PaymentService
3) Roles: Customer / Admin
4) Datos persistidos en MySQL
5) Frontend con plantillas Blade y CSS inline

---

## 4. Preguntas tipicas y respuestas sugeridas

Q: Como se calcula el total?
A: Se calcula en CheckoutService. Toma el subtotal del carrito y aplica IVA 15%.

Q: El pago es real?
A: No, es simulado. PaymentService crea un registro con referencia simulada.

Q: Como se controla el stock?
A: Al pagar, CheckoutService descuenta stock de los productos.
   Tambien se valida stock antes de confirmar el checkout.

Q: Como se separa admin y cliente?
A: Con roles en el modelo User y middlewares
   EnsureUserIsCustomer / EnsureUserIsAdmin.

Q: Cual es la estructura de datos?
A: Zona -> Categoria -> Producto. Carrito -> Items -> Producto.
   Orden de venta -> Items.

Q: Se puede integrar una pasarela real?
A: Si. Ya existe PaymentService con placeholders para Stripe.

---

## 5. Dificultades y decisiones
- Se priorizo un flujo de compra funcional sobre pagos reales.
- Se dejo inventario avanzado en modelos, pendiente de UI.
- Se ajusto a formato Ecuador (IVA 15%, USD, zona horaria).

---

## 6. Resultados / Avances
- CRUD completo de inventario basico (zonas, categorias, productos)
- Tienda operativa con carrito y checkout
- Perfil de cliente y pedidos
- Estilos responsivos y consistentes

---

## 7. Proximas mejoras que puedes mencionar
1) Middleware admin completo
2) Pagos reales con Stripe
3) Reportes de ventas e inventario
4) Auditoria y logs por accion
5) Notificaciones por email

