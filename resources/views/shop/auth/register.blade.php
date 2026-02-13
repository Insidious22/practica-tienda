@extends('layouts.shop')

@push('styles')
    @vite(['resources/css/shop/auth.css'])
@endpush

@section('content')
    <div class="auth-wrap">
        <div class="card">
            <div class="card-header auth-card-title">
                Crear Cuenta
            </div>
            <div class="card-body">
                <form action="{{ route('shop.register') }}" method="POST">
                    @csrf

                    <div class="form-group mb-3">
                        <label class="form-label">Nombre Completo</label>
                        <input type="text" name="name" class="form-input form-control" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <span class="form-error text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Correo Electronico</label>
                        <input type="email" name="email" class="form-input form-control" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="form-error text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Teléfono (opcional)</label>
                        <input type="tel" name="phone" class="form-input form-control" value="{{ old('phone') }}" placeholder="09 9999 9999">
                        @error('phone')
                            <span class="form-error text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-input form-control" required>
                        <small class="auth-helper">Minimo 8 caracteres</small>
                        @error('password')
                            <span class="form-error text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" class="form-input form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary auth-submit">
                        Crear Cuenta
                    </button>
                </form>

                <div class="auth-footer">
                    <p class="auth-footer-text">
                        ¿Ya tienes una cuenta?
                        <a href="{{ route('shop.login') }}" class="auth-link">Iniciar sesion</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
