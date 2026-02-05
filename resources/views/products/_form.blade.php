@php
    $isEdit = isset($product);
@endphp

<div class="form-row">
    <div class="form-group mb-3">
        <label for="category_id">🏷️ Categoría <span style="color: #ef4444;">*</span></label>
        <select id="category_id" name="category_id" class="form-select" required>
            <option value="">-- Seleccionar una categoría --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }} ({{ $cat->zone->name ?? 'Sin zona' }})
                </option>
            @endforeach
        </select>
        @error('category_id')
            <div class="muted" style="color: #ef4444; font-size: 12px; margin-top: 4px;">⚠️ {{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="barcode">📊 Código de Barras <span style="color: #ef4444;">*</span></label>
        <input id="barcode" name="barcode" type="text" class="form-control" placeholder="Ej: 1234567890" value="{{ old('barcode', $product->barcode ?? '') }}" required>
        @error('barcode')
            <div class="muted" style="color: #ef4444; font-size: 12px; margin-top: 4px;">⚠️ {{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-row">
    <div class="form-group mb-3">
        <label for="sku">📦 SKU (Opcional)</label>
        <input id="sku" name="sku" type="text" class="form-control" placeholder="Código único interno" value="{{ old('sku', $product->sku ?? '') }}">
        @error('sku')
            <div class="muted" style="color: #ef4444; font-size: 12px; margin-top: 4px;">⚠️ {{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="name">📝 Nombre del Producto <span style="color: #ef4444;">*</span></label>
        <input id="name" name="name" type="text" class="form-control" placeholder="Ej: Laptop Dell" value="{{ old('name', $product->name ?? '') }}" required>
        @error('name')
            <div class="muted" style="color: #ef4444; font-size: 12px; margin-top: 4px;">⚠️ {{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group mb-3">
    <label for="description">📄 Descripción (Opcional)</label>
    <textarea id="description" name="description" class="form-control" placeholder="Detalles adicionales del producto...">{{ old('description', $product->description ?? '') }}</textarea>
    @error('description')
        <div class="muted" style="color: #ef4444; font-size: 12px; margin-top: 4px;">⚠️ {{ $message }}</div>
    @enderror
</div>

<div class="form-row">
    <div class="form-group mb-3">
        <label for="price">💰 Precio (Opcional)</label>
        <input id="price" name="price" type="number" class="form-control" step="0.01" min="0" placeholder="0.00" value="{{ old('price', $product->price ?? '') }}">
        @error('price')
            <div class="muted" style="color: #ef4444; font-size: 12px; margin-top: 4px;">⚠️ {{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="stock_quantity">📊 Cantidad en Stock <span style="color: #ef4444;">*</span></label>
        <input id="stock_quantity" name="stock_quantity" type="number" class="form-control" step="0.001" min="0" placeholder="0" value="{{ old('stock_quantity', $product->stock_quantity ?? '') }}" required>
        @error('stock_quantity')
            <div class="muted" style="color: #ef4444; font-size: 12px; margin-top: 4px;">⚠️ {{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="unit">🎯 Unidad de Medida <span style="color: #ef4444;">*</span></label>
        <input id="unit" name="unit" type="text" class="form-control" placeholder="Ej: kg, unidad, litro" value="{{ old('unit', $product->unit ?? 'unidad') }}" required>
        @error('unit')
            <div class="muted" style="color: #ef4444; font-size: 12px; margin-top: 4px;">⚠️ {{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group mb-3">
    <label for="status">✓ Estado <span style="color: #ef4444;">*</span></label>
    <select id="status" name="status" class="form-select" required>
        <option value="active" {{ old('status', $product->status ?? 'active') == 'active' ? 'selected' : '' }}>
            ✓ Activo - Disponible para venta
        </option>
        <option value="inactive" {{ old('status', $product->status ?? '') == 'inactive' ? 'selected' : '' }}>
            ⊘ Inactivo - Oculto temporalmente
        </option>
        <option value="discontinued" {{ old('status', $product->status ?? '') == 'discontinued' ? 'selected' : '' }}>
            ✗ Descontinuado - Fuera de producción
        </option>
    </select>
    @error('status')
        <div class="muted" style="color: #ef4444; font-size: 12px; margin-top: 4px;">⚠️ {{ $message }}</div>
    @enderror
</div>

<div class="form-actions">
    <button class="btn btn-primary" type="submit" style="gap: 8px;">
        <span>{{ $isEdit ? '💾 Actualizar Producto' : '➕ Guardar Producto' }}</span>
    </button>
    <a class="btn btn-secondary" href="{{ route('admin.productos.index') }}" style="gap: 8px;">
        <span>← Volver a Productos</span>
    </a>
</div>
