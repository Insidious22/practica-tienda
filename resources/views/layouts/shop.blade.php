<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Tienda Online' }} - {{ config('app.name', 'Mi Tienda') }}</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc;
            color: #1f2937;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .shop-header {
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-top {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px 0;
            font-size: 13px;
        }

        .header-top-content {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-main {
            max-width: 1280px;
            margin: 0 auto;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .shop-logo {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .shop-logo span {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Search */
        .search-form {
            flex: 1;
            max-width: 500px;
        }

        .search-input-wrapper {
            position: relative;
            display: flex;
        }

        .search-input {
            width: 100%;
            padding: 12px 16px;
            padding-right: 50px;
            border: 2px solid #e5e7eb;
            border-radius: 25px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
        }

        .search-btn {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Header Actions */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-link {
            color: #4b5563;
            text-decoration: none;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
        }

        .header-link:hover {
            color: #667eea;
        }

        .cart-icon {
            position: relative;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ef4444;
            color: white;
            font-size: 11px;
            font-weight: 700;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Navigation */
        .shop-nav {
            border-top: 1px solid #e5e7eb;
        }

        .nav-content {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            gap: 5px;
        }

        .nav-link {
            padding: 12px 16px;
            color: #4b5563;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            border-bottom: 2px solid transparent;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #667eea;
            border-bottom-color: #667eea;
        }

        /* Main Content */
        .shop-main {
            flex: 1;
            max-width: 1280px;
            width: 100%;
            margin: 0 auto;
            padding: 30px 20px;
        }

        /* Footer */
        .shop-footer {
            background: #1f2937;
            color: #9ca3af;
            padding: 40px 0 20px;
            margin-top: auto;
        }

        .footer-content {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
        }

        .footer-section h4 {
            color: white;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 8px;
        }

        .footer-section a {
            color: #9ca3af;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }

        .footer-section a:hover {
            color: white;
        }

        .footer-bottom {
            max-width: 1280px;
            margin: 30px auto 0;
            padding: 20px 20px 0;
            border-top: 1px solid #374151;
            text-align: center;
            font-size: 13px;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        .btn-outline {
            background: transparent;
            border: 2px solid #667eea;
            color: #667eea;
        }

        .btn-outline:hover {
            background: #667eea;
            color: white;
        }

        .btn-success {
            background: #10b981;
            color: white;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        /* Product Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 25px;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.1);
        }

        .product-image {
            aspect-ratio: 1;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-image-placeholder {
            font-size: 48px;
            opacity: 0.3;
        }

        .product-info {
            padding: 15px;
        }

        .product-category {
            font-size: 12px;
            color: #667eea;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .product-name {
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .product-name a {
            color: inherit;
            text-decoration: none;
        }

        .product-name a:hover {
            color: #667eea;
        }

        .product-price {
            font-size: 20px;
            font-weight: 700;
            color: #667eea;
        }

        .product-price-old {
            font-size: 14px;
            color: #9ca3af;
            text-decoration: line-through;
            margin-left: 8px;
        }

        .product-actions {
            padding: 0 15px 15px;
        }

        .add-to-cart-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .add-to-cart-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(102, 126, 234, 0.3);
        }

        /* Alerts */
        .alert {
            padding: 14px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border-left: 4px solid #10b981;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        .alert-warning {
            background: #fef3c7;
            color: #92400e;
            border-left: 4px solid #f59e0b;
        }

        .alert-info {
            background: #dbeafe;
            color: #1e40af;
            border-left: 4px solid #3b82f6;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #374151;
        }

        .form-input {
            width: 100%;
            padding: 12px 14px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
        }

        .form-error {
            color: #ef4444;
            font-size: 13px;
            margin-top: 5px;
        }

        /* Card */
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            overflow: hidden;
        }

        .card-header {
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
            font-weight: 600;
            font-size: 18px;
        }

        .card-body {
            padding: 20px;
        }

        /* Breadcrumb */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 20px;
        }

        .breadcrumb a {
            color: #6b7280;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            color: #667eea;
        }

        .breadcrumb-separator {
            color: #d1d5db;
        }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-primary { background: #dbeafe; color: #1e40af; }
        .badge-success { background: #dcfce7; color: #166534; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 30px;
        }

        .pagination a,
        .pagination span {
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            border: 1px solid #e5e7eb;
            color: #374151;
            font-size: 14px;
            transition: all 0.2s;
        }

        .pagination a:hover {
            background: #f3f4f6;
            border-color: #667eea;
            color: #667eea;
        }

        .pagination .active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        /* Utilities */
        .text-center { text-align: center; }
        .text-muted { color: #6b7280; }
        .mt-4 { margin-top: 16px; }
        .mb-4 { margin-bottom: 16px; }

        /* Responsive */
        @media (max-width: 768px) {
            .header-main {
                flex-wrap: wrap;
                gap: 15px;
            }

            .search-form {
                order: 3;
                max-width: 100%;
                width: 100%;
            }

            .header-actions {
                margin-left: auto;
            }

            .nav-content {
                overflow-x: auto;
            }

            .product-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .footer-content {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .product-grid {
                grid-template-columns: 1fr;
            }

            .header-top-content {
                flex-direction: column;
                gap: 5px;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="shop-header">
        <div class="header-top">
            <div class="header-top-content container">
                <span>Envio gratis en compras mayores a $50</span>
                <span>Atencion: Lun-Sab 9am-6pm</span>
            </div>
        </div>

        <div class="header-main container">
            <a href="{{ route('shop.home') }}" class="shop-logo">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 32px; height: 32px; color: #667eea;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span>Mi Tienda</span>
            </a>

            <form action="{{ route('shop.search') }}" method="GET" class="search-form">
                <div class="search-input-wrapper">
                    <input type="text" name="q" class="search-input" placeholder="Buscar productos..." value="{{ request('q') }}">
                    <button type="submit" class="search-btn">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </form>

            <div class="header-actions">
                @auth
                    <a href="{{ route('shop.account.index') }}" class="header-link">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ Auth::user()->name }}
                    </a>
                    <form action="{{ route('shop.logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="header-link" style="border: none; background: none; cursor: pointer; padding: 0;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Cerrar Sesion
                        </button>
                    </form>
                @else
                    <a href="{{ route('shop.login') }}" class="header-link">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Ingresar
                    </a>
                @endauth

                <a href="{{ route('shop.cart') }}" class="header-link cart-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    @php
                        $cartCount = 0;
                        if (Auth::check() && Auth::user()->cart) {
                            $cartCount = Auth::user()->cart->total_items;
                        }
                    @endphp
                    @if($cartCount > 0)
                        <span class="cart-count">{{ $cartCount }}</span>
                    @endif
                </a>
            </div>
        </div>

        <nav class="shop-nav">
            <div class="nav-content container">
                <a href="{{ route('shop.home') }}" class="nav-link @if(Route::currentRouteName() === 'shop.home') active @endif">Inicio</a>
                <a href="{{ route('shop.catalog') }}" class="nav-link @if(Route::currentRouteName() === 'shop.catalog') active @endif">Catalogo</a>
                @php
                    $navCategories = \App\Models\Category::take(5)->get();
                @endphp
                @foreach($navCategories as $navCategory)
                    <a href="{{ route('shop.category', $navCategory) }}" class="nav-link">{{ $navCategory->name }}</a>
                @endforeach
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="shop-main container">
        @if (session('success'))
            <div class="alert alert-success">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <div>
                    <strong>Por favor corrige los siguientes errores:</strong>
                    <ul style="margin: 5px 0 0 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="shop-footer">
        <div class="footer-content container">
            <div class="footer-section">
                <h4>Mi Tienda</h4>
                <p style="font-size: 14px; line-height: 1.6;">El comisariato de los rafatones.</p>
            </div>
            <div class="footer-section">
                <h4>Enlaces</h4>
                <ul>
                    <li><a href="{{ route('shop.home') }}">Inicio</a></li>
                    <li><a href="{{ route('shop.catalog') }}">Catalogo</a></li>
                    <li><a href="{{ route('shop.cart') }}">Carrito</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Mi Cuenta</h4>
                <ul>
                    @auth
                        <li><a href="{{ route('shop.account.index') }}">Mi Cuenta</a></li>
                        <li><a href="{{ route('shop.account.orders') }}">Mis Pedidos</a></li>
                    @else
                        <li><a href="{{ route('shop.login') }}">Iniciar Sesion</a></li>
                        <li><a href="{{ route('shop.register') }}">Registrarse</a></li>
                    @endauth
                </ul>
            </div>
            <div class="footer-section">
                <h4>Contacto</h4>
                <ul>
                    <li>Tel: +593 4 123-4567</li>
                    <li>Email: info@sapo.com</li>
                    <li>Dirección: Av. 9 de Octubre 123, Guayaquil</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom container">
            <p>&copy; {{ date('Y') }} Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        // Auto-close alerts
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.3s ease';
                setTimeout(() => alert.remove(), 300);
            });
        }, 5000);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>
