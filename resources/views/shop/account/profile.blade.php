@extends('layouts.shop')

@push('styles')
    @safeVite(['resources/css/shop/account.css'])
@endpush

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('shop.home') }}">Inicio</a>
        <span class="breadcrumb-separator">/</span>
        <a href="{{ route('shop.account.index') }}">Mi Cuenta</a>
        <span class="breadcrumb-separator">/</span>
        <span>Mi Perfil</span>
    </div>

    <h1 class="account-title">Mi Perfil</h1>

    <div class="account-layout">
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

                        <div class="account-profile-grid">
                            <div class="form-group mb-3">
                                <label class="form-label">Nombre Completo</label>
                                <input type="text" name="name" class="form-input form-control" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <span class="form-error text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Correo Electronico</label>
                                <input type="email" class="form-input form-control account-profile-input-disabled" value="{{ $user->email }}" disabled>
                                <small class="account-profile-helper">El correo no se puede cambiar</small>
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
                                    @foreach($documentTypes as $documentType)
                                        <option value="{{ $documentType->siglas }}" @selected(old('document_type', $user->document_type) === $documentType->siglas)>{{ $documentType->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Número de Documento</label>
                                <input type="text" name="document_number" class="form-input form-control" value="{{ old('document_number', $user->document_number) }}" placeholder="0102030405">
                                <small class="account-profile-helper">Cédula (10 dígitos) / RUC (13 dígitos)</small>
                                @error('document_number')
                                    <span class="form-error text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <hr class="account-profile-divider">

                        <h3 class="account-profile-section-title">Dirección de Envío</h3>

                        <div class="form-group mb-3">
                            <label class="form-label">Dirección (Calle y número)</label>
                            <input type="text" name="address" class="form-input form-control" value="{{ old('address', $user->address) }}" placeholder="Av. 9 de Octubre 123">
                            @error('address')
                                <span class="form-error text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="account-profile-grid">
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

                        <button type="submit" class="btn btn-primary account-profile-submit">
                            Guardar Cambios
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

