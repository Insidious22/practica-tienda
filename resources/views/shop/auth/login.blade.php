@extends('layouts.shop')

@section('content')
    <div style="max-width: 450px; margin: 40px auto;">
        <div class="card">
            <div class="card-header" style="text-align: center; font-size: 20px;">
                Iniciar Sesion
            </div>
            <div class="card-body">
                <form action="{{ route('shop.login') }}" method="POST">
                    @csrf

                    @if(request('redirect'))
                        <input type="hidden" name="redirect" value="{{ request('redirect') }}">
                    @endif

                    <div class="form-group">
                        <label class="form-label">Correo Electronico</label>
                        <input type="email" name="email" class="form-input" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Contrasena</label>
                        <input type="password" name="password" class="form-input" required>
                        @error('password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group" style="display: flex; align-items: center; gap: 8px;">
                        <input type="checkbox" name="remember" id="remember" style="width: auto;">
                        <label for="remember" style="margin: 0; font-weight: normal;">Recordarme</label>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px;">
                        Iniciar Sesion
                    </button>
                </form>

                <div style="text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                    <p style="color: #6b7280; margin-bottom: 10px;">¿No tienes una cuenta?</p>
                    <a href="{{ route('shop.register') }}" class="btn btn-outline" style="width: 100%;">
                        Crear cuenta
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
