<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Tienda') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @safeVite(['resources/css/app.css', 'resources/css/layouts/admin.css', 'resources/js/app.js'])
    @endif

    @stack('styles')

</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
            Tienda
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="@if(Route::currentRouteName() === 'admin.dashboard') active @endif">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-18">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9M9 21h6a2 2 0 002-2V9a2 2 0 00-2-2H9a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('admin.productos.index') }}" class="@if(str_starts_with(Route::currentRouteName(), 'admin.productos')) active @endif">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-18">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8-4 8 4m0 0v10l-8 4m8-4l-8 4m-8-4v10l8 4m-8-4l8-4"></path>
                </svg>
                Productos
            </a>
            <a href="{{ route('admin.categorias.index') }}" class="@if(str_starts_with(Route::currentRouteName(), 'admin.categorias')) active @endif">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-18">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                Categorías
            </a>
            <a href="{{ route('admin.zonas.index') }}" class="@if(str_starts_with(Route::currentRouteName(), 'admin.zonas')) active @endif">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-18">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l5.447-2.724A1 1 0 0021 16.382V5.618a1 1 0 00-1.447-.894L15 7m0 13V7m0 13l6-3"></path>
                </svg>
                Zonas
            </a>
            <a href="{{ route('admin.proveedores.index') }}" class="@if(str_starts_with(Route::currentRouteName(), 'admin.proveedores')) active @endif">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-18">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path>
                </svg>
                Proveedores
            </a>
            <a href="{{ route('admin.guardias.index') }}" class="@if(str_starts_with(Route::currentRouteName(), 'admin.guardias')) active @endif">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-18">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 10-8 0v1a4 4 0 108 0V7z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14a7 7 0 00-7 7v1h14v-1a7 7 0 00-7-7z"></path>
                </svg>
                Guardias
            </a>
            <a href="{{ route('admin.diccionario.index') }}" class="@if(str_starts_with(Route::currentRouteName(), 'admin.diccionario')) active @endif">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-18">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                Diccionario
            </a>
            @if (Auth::check() && Auth::user()->isSuperAdmin())
                <a href="{{ route('admin.users.index') }}" class="@if(str_starts_with(Route::currentRouteName(), 'admin.users')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-18">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8.048M6 19h12a2 2 0 012 2v2H4v-2a2 2 0 012-2zM12 2a6 6 0 100 12 6 6 0 000-12z"></path>
                    </svg>
                    Usuarios
                </a>
            @endif
            <a href="{{ route('shop.home') }}" class="sidebar-divider-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-18">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Ver Tienda
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" class="sidebar-logout-form">
                @csrf
                <button type="submit" class="sidebar-logout-button">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-18">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Cerrar Sesión
                </button>
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <h1 class="topbar-title">{{ $title ?? config('app.name', 'Tienda') }}</h1>
            <div class="topbar-user">
                <span class="topbar-user-label">Usuario</span>
                <div class="user-avatar">U</div>
            </div>
        </div>

        <!-- Container -->
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">
                    <span>?</span>
                    <span>{{ session('success') }}</span>
                    <span class="alert-close" onclick="this.parentElement.style.display='none'">?</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <span>!</span>
                    <div>
                        <strong>¡Error!</strong>
                        <ul class="alert-list">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script>
        // Highlight active nav link
        document.querySelectorAll('.sidebar-nav a').forEach(link => {
            if (link.href === window.location.href) {
                link.classList.add('active');
            }
        });
        
        // Auto-close alerts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                if (alert.classList.contains('success')) {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.3s ease';
                    setTimeout(() => alert.remove(), 300);
                }
            });
        }, 5000);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
