@extends('layouts.shop')

@section('content')
    <div class="auth-wrap auth-wrap--sm">
        <div class="card">
            <div class="card-header auth-card-title">
                Iniciar Sesion
            </div>
            <div class="card-body">
                <form action="{{ route('shop.login') }}" method="POST">
                    @csrf

                    @if(request('redirect'))
                        <input type="hidden" name="redirect" value="{{ request('redirect') }}">
                    @endif

                    <div class="form-group mb-3">
                        <label class="form-label">Correo Electronico</label>
                        <input type="email" name="email" class="form-input form-control" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span class="form-error text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-input form-control" required>
                        @error('password')
                            <span class="form-error text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3 auth-remember">
                        <input type="checkbox" name="remember" id="remember" class="auth-checkbox">
                        <label for="remember" class="auth-checkbox-label">Recordarme</label>
                    </div>

                    <button type="submit" class="btn btn-primary auth-submit">
                        Iniciar Sesion
                    </button>
                </form>

                <div class="auth-footer">
                    <p class="auth-footer-text">¿No tienes una cuenta?</p>
                    <a href="{{ route('shop.register') }}" class="btn btn-outline auth-submit">
                        Crear cuenta
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
