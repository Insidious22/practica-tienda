<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Tienda Online' }} - {{ config('app.name', 'Mi Tienda') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @safeVite(['resources/css/app.css', 'resources/css/bundles/shop.css', 'resources/js/app.js'])
        @endif

        @stack('styles')

</head>
<body>
    <x-turbo-loader />

    <!-- Header -->
    <header class="shop-header">
        <div class="header-top">
            <div class="header-top-content container">
                <span>Envio gratis a todas tus compras</span>
                <span>Atencion: Lun-Sab 9am-6pm</span>
            </div>
        </div>

        <div class="header-main container">
            <a href="{{ route('shop.home') }}" class="shop-logo" data-turbo-prefetch>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="shop-logo-icon">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span>Mi Tienda</span>
            </a>

            <form action="{{ route('shop.search') }}" method="GET" class="search-form">
                <div class="search-input-wrapper">
                    <input type="text" name="q" class="search-input" placeholder="Buscar productos..." value="{{ request('q') }}">
                    <button type="submit" class="search-btn">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-18">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </form>

            <div class="header-actions">
                @auth
                    <a href="{{ route('shop.account.index') }}" class="header-link" data-turbo-prefetch>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-20">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ Auth::user()->name }}
                    </a>
                    <form action="{{ route('shop.logout') }}" method="POST" class="header-actions-form">
                        @csrf
                        <button type="submit" class="header-link header-link-button">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-20">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Cerrar Sesion
                        </button>
                    </form>
                @else
                    <a href="{{ route('shop.login') }}" class="header-link" data-turbo-prefetch>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-20">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Ingresar
                    </a>
                @endauth

                <a href="{{ route('shop.cart') }}" class="header-link cart-icon" data-turbo-prefetch>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-24">
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
                <a href="{{ route('shop.home') }}" class="nav-link @if(Route::currentRouteName() === 'shop.home') active @endif" data-turbo-prefetch>Inicio</a>
                <a href="{{ route('shop.catalog') }}" class="nav-link @if(Route::currentRouteName() === 'shop.catalog') active @endif" data-turbo-prefetch>Catalogo</a>
                @php
                    $navCategories = \Illuminate\Support\Facades\Cache::remember(
                        'shop.nav.categories',
                        now()->addMinutes(10),
                        fn () => \App\Models\Category::query()->select(['id', 'name'])->orderBy('name')->take(5)->get()
                    );
                @endphp
                @foreach($navCategories as $navCategory)
                    <a href="{{ route('shop.category', $navCategory) }}" class="nav-link" data-turbo-prefetch>{{ $navCategory->name }}</a>
                @endforeach
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="shop-main container">
        @if (session('success'))
            <div class="alert alert-success">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-20">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-20">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <div>
                    <strong>Por favor corrige los siguientes errores:</strong>
                    <ul class="alert-list">
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
                <p class="footer-text">El comisariato de los rafatones.</p>
            </div>
            <div class="footer-section">
                <h4>Enlaces</h4>
                <ul>
                    <li><a href="{{ route('shop.home') }}" data-turbo-prefetch>Inicio</a></li>
                    <li><a href="{{ route('shop.catalog') }}" data-turbo-prefetch>Catalogo</a></li>
                    <li><a href="{{ route('shop.cart') }}" data-turbo-prefetch>Carrito</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Mi Cuenta</h4>
                <ul>
                    @auth
                        <li><a href="{{ route('shop.account.index') }}" data-turbo-prefetch>Mi Cuenta</a></li>
                        <li><a href="{{ route('shop.account.orders') }}" data-turbo-prefetch>Mis Pedidos</a></li>
                    @else
                        <li><a href="{{ route('shop.login') }}" data-turbo-prefetch>Iniciar Sesion</a></li>
                        <li><a href="{{ route('shop.register') }}" data-turbo-prefetch>Registrarse</a></li>
                    @endauth
                </ul>
            </div>
            <div class="footer-section">
                <h4>Contacto</h4>
                <ul>
                    <li>Tel: +593 4 123-4567</li>
                    <li>Email: info@sapo.com</li>
                    <li>Dirección: Av. 9 de Octubre no, En la Chile y Colon tampoco, en Guayaquil</li>
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
