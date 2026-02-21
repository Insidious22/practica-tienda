@php
    $isEdit = isset($product);
@endphp

<div class="form-row">
    <div class="form-group mb-3">
        <label for="category_id">Categoria <span class="product-required">*</span></label>
        <select id="category_id" name="category_id" class="form-select" required>
            <option value="">-- Seleccionar una categoria --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }} ({{ $cat->zone?->name ?? 'Sin zona' }})
                </option>
            @endforeach
        </select>
        @error('category_id')
            <div class="product-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="barcode">Codigo de Barras <span class="product-required">*</span></label>
        <input id="barcode" name="barcode" type="text" class="form-control" placeholder="Ej: 1234567890" value="{{ old('barcode', $product->barcode ?? '') }}" required>
        @error('barcode')
            <div class="product-error">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-row">
    <div class="form-group mb-3">
        <label for="sku">SKU (Opcional)</label>
        <input id="sku" name="sku" type="text" class="form-control" placeholder="Codigo unico interno" value="{{ old('sku', $product->sku ?? '') }}">
        @error('sku')
            <div class="product-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="name">Nombre del Producto <span class="product-required">*</span></label>
        <input id="name" name="name" type="text" class="form-control" placeholder="Ej: Laptop Dell" value="{{ old('name', $product->name ?? '') }}" required>
        @error('name')
            <div class="product-error">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group mb-3">
    <label for="description">Descripcion (Opcional)</label>
    <textarea id="description" name="description" class="form-control" placeholder="Detalles adicionales del producto...">{{ old('description', $product->description ?? '') }}</textarea>
    @error('description')
        <div class="product-error">{{ $message }}</div>
    @enderror
</div>

<div class="form-row">
    <div class="form-group mb-3">
        <label for="price">Precio (Opcional)</label>
        <input id="price" name="price" type="number" class="form-control" step="0.01" min="0" placeholder="0.00" value="{{ old('price', $product->price ?? '') }}">
        @error('price')
            <div class="product-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="stock_quantity">Cantidad en Stock <span class="product-required">*</span></label>
        <input id="stock_quantity" name="stock_quantity" type="number" class="form-control" step="0.001" min="0" placeholder="0" value="{{ old('stock_quantity', $product->stock_quantity ?? '') }}" required>
        @error('stock_quantity')
            <div class="product-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="unit">Unidad de Medida <span class="product-required">*</span></label>
        <select id="unit" name="unit" class="form-select" required>
            @foreach($unitOptions as $unitOption)
                <option value="{{ $unitOption->siglas }}" {{ old('unit', $product->unit ?? 'UNI') == $unitOption->siglas ? 'selected' : '' }}>
                    {{ $unitOption->descripcion }}
                </option>
            @endforeach
        </select>
        @error('unit')
            <div class="product-error">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group mb-3">
    <label for="status">Estado <span class="product-required">*</span></label>
    <select id="status" name="status" class="form-select" required>
        @foreach($statusOptions as $statusOption)
            <option value="{{ $statusOption->siglas }}" {{ old('status', $product->status ?? 'ACT') == $statusOption->siglas ? 'selected' : '' }}>
                {{ $statusOption->descripcion }}
            </option>
        @endforeach
    </select>
    @error('status')
        <div class="product-error">{{ $message }}</div>
    @enderror
</div>

<div class="form-actions">
    <button class="btn btn-primary product-action-btn product-action-btn--lg" type="submit">
        <span>{{ $isEdit ? 'Actualizar Producto' : 'Guardar Producto' }}</span>
    </button>
    <a class="btn btn-secondary product-action-btn product-action-btn--lg" href="{{ route('admin.productos.index') }}">
        <span>Volver a Productos</span>
    </a>
</div>
