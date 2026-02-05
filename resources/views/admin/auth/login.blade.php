@extends('layouts.app')

@section('content')
<div style="max-width: 500px; margin: 100px auto;">
    <div class="container">
        <div class="header" style="justify-content: center; margin-bottom: 40px;">
            <h1 class="title" style="text-align: center;">ACCESO ADMINISTRACIÓN</h1>
        </div>

        @if ($errors->any())
            <div class="alert danger" style="margin-bottom: 20px;">
                <span>!</span>
                <div>
                    <strong>Error al iniciar sesión</strong>
                    <ul style="margin: 5px 0 0 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
            @csrf

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1f2937;">Correo Electrónico</label>
                <input type="email" name="email" class="form-input" value="{{ old('email') }}" required autofocus style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                @error('email')
                    <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1f2937;">Contraseña</label>
                <input type="password" name="password" class="form-input" required style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                @error('password')
                    <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                <input type="checkbox" name="remember" id="remember" style="width: auto;">
                <label for="remember" style="margin: 0; font-weight: normal;">Recordarme</label>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                Iniciar Sesión
            </button>
        </form>

        <p style="text-align: center; margin-top: 20px; color: #6b7280; font-size: 13px;">
            ¿No tienes cuenta? Contacta al administrador del sistema.
        </p>
    </div>
</div>
@endsection
