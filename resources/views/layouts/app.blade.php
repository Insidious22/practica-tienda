<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Tienda') }}</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { --scrollbar-width: thin; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #1f2937;
            min-height: 100vh;
            padding-bottom: 40px;
        }
        
        /* Sidebar & Navigation */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: #1f2937;
            color: #fff;
            padding: 20px 0;
            overflow-y: auto;
            box-shadow: 2px 0 8px rgba(0,0,0,0.15);
            z-index: 1000;
        }
        
        .sidebar-logo {
            padding: 0 20px 30px;
            font-size: 20px;
            font-weight: 700;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .sidebar-logo svg {
            width: 24px;
            height: 24px;
        }
        
        .sidebar-nav {
            display: flex;
            flex-direction: column;
        }
        
        .sidebar-nav a {
            padding: 12px 20px;
            color: #d1d5db;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background: rgba(255,255,255,0.1);
            color: #fff;
            border-left-color: #667eea;
            padding-left: 17px;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 30px;
        }
        
        .topbar {
            background: white;
            padding: 20px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            margin: -30px -30px 30px -30px;
            padding-left: 30px;
            padding-right: 30px;
        }
        
        .topbar-title {
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .topbar-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
        }
        
        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
            padding: 30px;
        }
        
        /* Header Section */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f3f4f6;
        }
        
        .title {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }
        
        .header-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            gap: 6px;
        }
        
        .btn.primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn.primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.4);
        }
        
        .btn.secondary {
            background: #f3f4f6;
            color: #374151;
        }
        
        .btn.secondary:hover {
            background: #e5e7eb;
            transform: translateY(-2px);
        }
        
        .btn.danger {
            background: #ef4444;
            color: white;
        }
        
        .btn.danger:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }
        
        .btn.success {
            background: #10b981;
            color: white;
        }
        
        .btn.success:hover {
            background: #059669;
        }
        
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        /* Table */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .table thead {
            background: #f9fafb;
        }
        
        .table th,
        .table td {
            text-align: left;
            padding: 14px 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }
        
        .table th {
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        
        .table tbody tr {
            transition: background 0.2s ease;
        }
        
        .table tbody tr:hover {
            background: #f9fafb;
        }
        
        .table .actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        
        .table .actions form {
            display: inline;
        }
        
        /* Badge */
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge.primary {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .badge.success {
            background: #dcfce7;
            color: #166534;
        }
        
        .badge.danger {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .badge.warning {
            background: #fef3c7;
            color: #92400e;
        }
        
        /* Form */
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #374151;
            font-size: 14px;
        }
        
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }
        
        /* Alert */
        .alert {
            padding: 14px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
        }
        
        .alert.success {
            background: #dcfce7;
            color: #166534;
            border-left: 4px solid #10b981;
        }
        
        .alert.danger {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }
        
        .alert.warning {
            background: #fef3c7;
            color: #92400e;
            border-left: 4px solid #f59e0b;
        }
        
        .alert.info {
            background: #dbeafe;
            color: #1e40af;
            border-left: 4px solid #3b82f6;
        }
        
        .alert-close {
            margin-left: auto;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.2s;
        }
        
        .alert-close:hover {
            opacity: 1;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        
        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }
        
        .empty-state-text {
            color: #6b7280;
            margin-bottom: 20px;
        }
        
        /* Pagination */
        .pagination {
            margin-top: 30px;
        }

        .pagination nav {
            width: 100%;
        }

        .pagination nav > div {
            display: flex;
            justify-content: center;
        }

        .pagination nav > div > div:first-child {
            display: none;
        }

        .pagination nav .inline-flex {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 8px;
        }

        .pagination nav a,
        .pagination nav [aria-current="page"] > span,
        .pagination nav [aria-disabled="true"] > span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
            padding: 0 12px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            background: #fff;
            color: #374151;
            font-size: 14px;
            line-height: 1;
            text-decoration: none;
        }

        .pagination nav a:hover {
            background: #f3f4f6;
            border-color: #667eea;
            color: #667eea;
        }

        .pagination nav [aria-current="page"] > span {
            background: #667eea;
            color: #fff;
            border-color: #667eea;
            font-weight: 700;
        }

        .pagination nav [aria-disabled="true"] > span {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination nav svg {
            width: 16px;
            height: 16px;
            display: block;
        }
        
        /* Search Box */
        .search-box {
            position: relative;
        }
        
        .search-box input {
            padding: 10px 12px 10px 36px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            width: 100%;
            max-width: 300px;
        }
        
        .search-box::before {
            content: "🔍";
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0.5;
        }
        
        /* Stats Card */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            border-left: 4px solid #667eea;
        }
        
        .stat-card.primary { border-left-color: #667eea; }
        .stat-card.success { border-left-color: #10b981; }
        .stat-card.danger { border-left-color: #ef4444; }
        .stat-card.warning { border-left-color: #f59e0b; }
        
        .stat-label {
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #1f2937;
        }
        
        /* Utility */
        .muted {
            color: #6b7280;
            font-size: 13px;
        }
        
        .text-center {
            text-align: center;
        }
        
        .flex {
            display: flex;
        }
        
        .gap-2 { gap: 8px; }
        .gap-3 { gap: 12px; }
        .gap-4 { gap: 16px; }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow: hidden;
            }
            
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            
            .topbar {
                flex-direction: column;
                align-items: flex-start;
                margin: -15px -15px 15px -15px;
            }
            
            .container {
                padding: 15px;
            }
            
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .header-actions {
                width: 100%;
            }
            
            .header-actions .btn {
                flex: 1;
                justify-content: center;
            }
            
            .table {
                font-size: 12px;
            }
            
            .table th,
            .table td {
                padding: 10px 6px;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 480px) {
            .topbar-title {
                font-size: 20px;
            }
            
            .title {
                font-size: 18px;
            }
            
            .table .actions {
                flex-wrap: wrap;
            }
        }
    </style>
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
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9M9 21h6a2 2 0 002-2V9a2 2 0 00-2-2H9a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('admin.productos.index') }}" class="@if(str_starts_with(Route::currentRouteName(), 'admin.productos')) active @endif">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8-4 8 4m0 0v10l-8 4m8-4l-8 4m-8-4v10l8 4m-8-4l8-4"></path>
                </svg>
                Productos
            </a>
            <a href="{{ route('admin.categorias.index') }}" class="@if(str_starts_with(Route::currentRouteName(), 'admin.categorias')) active @endif">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                Categorías
            </a>
            <a href="{{ route('admin.zonas.index') }}" class="@if(str_starts_with(Route::currentRouteName(), 'admin.zonas')) active @endif">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l5.447-2.724A1 1 0 0021 16.382V5.618a1 1 0 00-1.447-.894L15 7m0 13V7m0 13l6-3"></path>
                </svg>
                Zonas
            </a>
            <a href="{{ route('admin.proveedores.index') }}" class="@if(str_starts_with(Route::currentRouteName(), 'admin.proveedores')) active @endif">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path>
                </svg>
                Proveedores
            </a>
            @if (Auth::check() && Auth::user()->isSuperAdmin())
                <a href="{{ route('admin.users.index') }}" class="@if(str_starts_with(Route::currentRouteName(), 'admin.users')) active @endif">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8.048M6 19h12a2 2 0 012 2v2H4v-2a2 2 0 012-2zM12 2a6 6 0 100 12 6 6 0 000-12z"></path>
                    </svg>
                    Usuarios
                </a>
            @endif
            <a href="{{ route('shop.home') }}" style="margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Ver Tienda
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" style="margin-top: 10px;">
                @csrf
                <button type="submit" style="width: 100%; padding: 12px 20px; color: #d1d5db; background: none; border: none; text-decoration: none; border-left: 3px solid transparent; transition: all 0.2s ease; display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 16px;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
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
                <span style="font-size: 14px; color: #6b7280;">Usuario</span>
                <div class="user-avatar">U</div>
            </div>
        </div>

        <!-- Container -->
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">
                    <span>✓</span>
                    <span>{{ session('success') }}</span>
                    <span class="alert-close" onclick="this.parentElement.style.display='none'">✕</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <span>!</span>
                    <div>
                        <strong>¡Error!</strong>
                        <ul style="margin: 5px 0 0 0; padding-left: 20px;">
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

