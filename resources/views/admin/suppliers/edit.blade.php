@extends('layouts.app')

@push('styles')
    @vite(['resources/css/admin/suppliers.css'])
@endpush

@section('content')
<div class="header">
    <h1 class="title">Editar Proveedor</h1>
</div>

<div class="admin-form-container">
    <form action="{{ route('admin.proveedores.update', $supplier) }}" method="POST" class="admin-form-card">
        @csrf
        @method('PUT')

        <div class="admin-form-group">
            <label class="admin-form-label">Codigo</label>
            <input type="text" name="code" value="{{ old('code', $supplier->code) }}" required class="admin-form-input">
            @error('code')
                <span class="admin-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form-group">
            <label class="admin-form-label">Razon Social</label>
            <input type="text" name="business_name" value="{{ old('business_name', $supplier->business_name) }}" required class="admin-form-input">
            @error('business_name')
                <span class="admin-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form-group">
            <label class="admin-form-label">Nombre Comercial</label>
            <input type="text" name="trade_name" value="{{ old('trade_name', $supplier->trade_name) }}" class="admin-form-input">
            @error('trade_name')
                <span class="admin-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form-group">
            <label class="admin-form-label">Persona de Contacto</label>
            <input type="text" name="contact_name" value="{{ old('contact_name', $supplier->contact_name) }}" class="admin-form-input">
            @error('contact_name')
                <span class="admin-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form-grid">
            <div>
                <label class="admin-form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', $supplier->email) }}" class="admin-form-input">
                @error('email')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="admin-form-label">Telefono</label>
                <input type="tel" name="phone" value="{{ old('phone', $supplier->phone) }}" class="admin-form-input">
                @error('phone')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="admin-form-group">
            <label class="admin-form-label">Direccion</label>
            <input type="text" name="address" value="{{ old('address', $supplier->address) }}" class="admin-form-input">
            @error('address')
                <span class="admin-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form-grid">
            <div>
                <label class="admin-form-label">Ciudad</label>
                <input type="text" name="city" value="{{ old('city', $supplier->city) }}" class="admin-form-input">
                @error('city')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="admin-form-label">RUC/NIT</label>
                <input type="text" name="tax_id" value="{{ old('tax_id', $supplier->tax_id) }}" class="admin-form-input">
                @error('tax_id')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="admin-form-group">
            <label class="admin-form-label">Condiciones de Pago</label>
            <input type="text" name="payment_terms" value="{{ old('payment_terms', $supplier->payment_terms) }}" class="admin-form-input">
            @error('payment_terms')
                <span class="admin-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form-group">
            <label class="admin-form-label">Notas</label>
            <textarea name="notes" rows="3" class="admin-form-textarea">{{ old('notes', $supplier->notes) }}</textarea>
            @error('notes')
                <span class="admin-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form-group admin-form-group--lg">
            <label class="admin-form-label">Estado</label>
            <select name="status" required class="admin-form-select">
                @foreach($statusOptions as $statusOption)
                    <option value="{{ $statusOption->siglas }}" {{ old('status', $supplier->status) === $statusOption->siglas ? 'selected' : '' }}>
                        {{ $statusOption->descripcion }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <span class="admin-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form-actions">
            <button type="submit" class="btn btn-primary admin-form-button">
                Actualizar Proveedor
            </button>
            <a href="{{ route('admin.proveedores.index') }}" class="btn btn-outline admin-form-button">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
