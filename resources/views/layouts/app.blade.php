<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? config('app.name', 'Tienda') }}</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            :root { color-scheme: light; }
            body { font-family: Arial, Helvetica, sans-serif; background: #f6f7fb; color: #1f2937; margin: 0; }
            .container { max-width: 980px; margin: 32px auto; padding: 24px; background: #fff; border-radius: 12px; box-shadow: 0 6px 20px rgba(0,0,0,0.08); }
            .header { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 20px; }
            .title { font-size: 24px; font-weight: 700; margin: 0; }
            .btn { display: inline-block; padding: 8px 14px; border-radius: 8px; text-decoration: none; background: #2563eb; color: #fff; font-weight: 600; }
            .btn.secondary { background: #e5e7eb; color: #111827; }
            .btn.danger { background: #dc2626; color: #fff; }
            .table { width: 100%; border-collapse: collapse; margin-top: 12px; }
            .table th, .table td { border-bottom: 1px solid #e5e7eb; text-align: left; padding: 10px; }
            .badge { display: inline-block; padding: 4px 8px; border-radius: 999px; background: #eef2ff; color: #3730a3; font-size: 12px; }
            .form-group { margin-bottom: 14px; }
            .form-group label { display: block; font-weight: 600; margin-bottom: 6px; }
            .form-group input, .form-group textarea { width: 100%; padding: 8px 10px; border: 1px solid #d1d5db; border-radius: 8px; }
            .actions { display: flex; gap: 8px; align-items: center; }
            .alert { padding: 10px 12px; background: #ecfccb; color: #365314; border-radius: 8px; margin-bottom: 16px; }
            .muted { color: #6b7280; font-size: 14px; }
        </style>
    </head>
    <body>
        <div class="container">
            <nav style="display:flex; gap:8px; margin-bottom:12px;">
                <a class="btn secondary" href="{{ route('productos.index') }}">Productos</a>
                <a class="btn secondary" href="{{ route('categorias.index') }}">Categorías</a>
                <a class="btn secondary" href="{{ route('zonas.index') }}">Zonas</a>
            </nav>

            @if (session('success'))
                <div class="alert">{{ session('success') }}</div>
            @endif

            @yield('content')
        </div>
    </body>
</html>
