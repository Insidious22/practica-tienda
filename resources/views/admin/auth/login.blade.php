@extends('layouts.app')

@section('content')
<div class="auth-wrapper">
    <div class="container">
        <div class="header auth-header">
            <h1 class="title auth-title">ACCESO ADMINISTRACIÓN</h1>
        </div>

        @if ($errors->any())
            <div class="alert danger">
                <span>!</span>
                <div>
                    <strong>Error al iniciar sesión</strong>
                    <ul class="alert-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST" class="admin-form-card">
            @csrf

            <div class="admin-form-group">
                <label class="admin-form-label">Correo Electrónico</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus class="admin-form-input">
                @error('email')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label">Contraseña</label>
                <input type="password" name="password" required class="admin-form-input">
                @error('password')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="admin-form-checkbox-row">
                <input type="checkbox" name="remember" id="remember" class="admin-form-checkbox">
                <label for="remember" class="admin-form-checkbox-label">Recordarme</label>
            </div>

            <button type="submit" class="btn btn-primary admin-form-button">
                Iniciar Sesión
            </button>
        </form>

        <p class="auth-footer">
            ¿No tienes cuenta? Contacta al administrador del sistema.
        </p>
    </div>
</div>
@endsection
