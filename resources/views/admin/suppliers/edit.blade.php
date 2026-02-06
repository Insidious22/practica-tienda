@extends('layouts.app')

@section('content')
<div class="header">
    <h1 class="title">Editar Proveedor</h1>
</div>

<div style="max-width: 600px;">
    <form action="{{ route('admin.proveedores.update', $supplier) }}" method="POST" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1f2937;">Codigo</label>
            <input type="text" name="code" value="{{ old('code', $supplier->code) }}" required style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; box-sizing: border-box;">
            @error('code')
                <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1f2937;">Razon Social</label>
            <input type="text" name="business_name" value="{{ old('business_name', $supplier->business_name) }}" required style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; box-sizing: border-box;">
            @error('business_name')
                <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1f2937;">Nombre Comercial</label>
            <input type="text" name="trade_name" value="{{ old('trade_name', $supplier->trade_name) }}" style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; box-sizing: border-box;">
            @error('trade_name')
                <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1f2937;">Persona de Contacto</label>
            <input type="text" name="contact_name" value="{{ old('contact_name', $supplier->contact_name) }}" style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; box-sizing: border-box;">
            @error('contact_name')
                <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1f2937;">Email</label>
                <input type="email" name="email" value="{{ old('email', $supplier->email) }}" style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; box-sizing: border-box;">
                @error('email')
                    <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1f2937;">Telefono</label>
                <input type="tel" name="phone" value="{{ old('phone', $supplier->phone) }}" style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; box-sizing: border-box;">
                @error('phone')
                    <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1f2937;">Direccion</label>
            <input type="text" name="address" value="{{ old('address', $supplier->address) }}" style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; box-sizing: border-box;">
            @error('address')
                <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1f2937;">Ciudad</label>
                <input type="text" name="city" value="{{ old('city', $supplier->city) }}" style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; box-sizing: border-box;">
                @error('city')
                    <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1f2937;">RUC/NIT</label>
                <input type="text" name="tax_id" value="{{ old('tax_id', $supplier->tax_id) }}" style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; box-sizing: border-box;">
                @error('tax_id')
                    <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1f2937;">Condiciones de Pago</label>
            <input type="text" name="payment_terms" value="{{ old('payment_terms', $supplier->payment_terms) }}" style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; box-sizing: border-box;">
            @error('payment_terms')
                <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1f2937;">Notas</label>
            <textarea name="notes" rows="3" style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; box-sizing: border-box;">{{ old('notes', $supplier->notes) }}</textarea>
            @error('notes')
                <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 30px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1f2937;">Estado</label>
            <select name="status" required style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; box-sizing: border-box;">
                <option value="active" {{ old('status', $supplier->status) === 'active' ? 'selected' : '' }}>Activo</option>
                <option value="inactive" {{ old('status', $supplier->status) === 'inactive' ? 'selected' : '' }}>Inactivo</option>
            </select>
            @error('status')
                <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: flex; gap: 12px;">
            <button type="submit" class="btn btn-primary" style="flex: 1; padding: 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                Actualizar Proveedor
            </button>
            <a href="{{ route('admin.proveedores.index') }}" class="btn btn-outline" style="flex: 1; padding: 12px; background: white; border: 1px solid #e5e7eb; border-radius: 8px; color: #1f2937; text-decoration: none; font-weight: 600; text-align: center;">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
