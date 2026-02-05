@extends('layouts.shop')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('shop.home') }}">Inicio</a>
        <span class="breadcrumb-separator">/</span>
        <a href="{{ route('shop.account.index') }}">Mi Cuenta</a>
        <span class="breadcrumb-separator">/</span>
        <span>Mi Perfil</span>
    </div>

    <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 30px;">Mi Perfil</h1>

    <div style="display: grid; grid-template-columns: 250px 1fr; gap: 30px;">
        <!-- Sidebar -->
        @include('shop.account._sidebar')

        <!-- Content -->
        <div>
            <div class="card">
                <div class="card-header">Informacion Personal</div>
                <div class="card-body">
                    <form action="{{ route('shop.account.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div class="form-group mb-3">
                                <label class="form-label">Nombre Completo</label>
                                <input type="text" name="name" class="form-input form-control" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <span class="form-error text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Correo Electronico</label>
                                <input type="email" class="form-input form-control" value="{{ $user->email }}" disabled style="background: #f9fafb;">
                                <small style="color: #6b7280; font-size: 12px;">El correo no se puede cambiar</small>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Teléfono</label>
                                <input type="tel" name="phone" class="form-input form-control" value="{{ old('phone', $user->phone) }}" placeholder="09 9999 9999">
                                @error('phone')
                                    <span class="form-error text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Tipo de Documento</label>
                                <select name="document_type" class="form-input form-select">
                                    <option value="">Seleccionar...</option>
                                    <option value="CEDULA" @selected(old('document_type', $user->document_type) === 'CEDULA')>Cédula</option>
                                    <option value="RUC" @selected(old('document_type', $user->document_type) === 'RUC')>RUC</option>
                                    <option value="PASAPORTE" @selected(old('document_type', $user->document_type) === 'PASAPORTE')>Pasaporte</option>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Número de Documento</label>
                                <input type="text" name="document_number" class="form-input form-control" value="{{ old('document_number', $user->document_number) }}" placeholder="0102030405">
                                <small style="color: #6b7280; font-size: 12px;">Cédula (10 dígitos) / RUC (13 dígitos)</small>
                                @error('document_number')
                                    <span class="form-error text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <hr style="margin: 30px 0; border: none; border-top: 1px solid #e5e7eb;">

                        <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Dirección de Envío</h3>

                        <div class="form-group mb-3">
                            <label class="form-label">Dirección (Calle y número)</label>
                            <input type="text" name="address" class="form-input form-control" value="{{ old('address', $user->address) }}" placeholder="Av. 9 de Octubre 123">
                            @error('address')
                                <span class="form-error text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div class="form-group mb-3">
                                <label class="form-label">Cantón / Ciudad</label>
                                <input type="text" name="city" class="form-input form-control" value="{{ old('city', $user->city) }}" placeholder="Guayaquil (Guayas)">
                                @error('city')
                                    <span class="form-error text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Código Postal (6 dígitos)</label>
                                <input type="text" name="postal_code" class="form-input form-control" value="{{ old('postal_code', $user->postal_code) }}" placeholder="090101">
                                @error('postal_code')
                                    <span class="form-error text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" style="margin-top: 10px;">
                            Guardar Cambios
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 768px) {
            [style*="grid-template-columns: 250px 1fr"] {
                grid-template-columns: 1fr !important;
            }
            [style*="grid-template-columns: 1fr 1fr"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endsection
