@extends('layouts.shop')

@section('content')
    <div style="max-width: 500px; margin: 40px auto;">
        <div class="card">
            <div class="card-header" style="text-align: center; font-size: 20px;">
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
                        <label class="form-label">Contrasena</label>
                        <input type="password" name="password" class="form-input form-control" required>
                        <small style="color: #6b7280; font-size: 12px;">Minimo 8 caracteres</small>
                        @error('password')
                            <span class="form-error text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Confirmar Contrasena</label>
                        <input type="password" name="password_confirmation" class="form-input form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px;">
                        Crear Cuenta
                    </button>
                </form>

                <div style="text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                    <p style="color: #6b7280;">
                        ¿Ya tienes una cuenta?
                        <a href="{{ route('shop.login') }}" style="color: #667eea; text-decoration: none; font-weight: 500;">Iniciar sesion</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
