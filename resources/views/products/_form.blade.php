@php
    $isEdit = isset($product);
@endphp

<div class="form-group">
    <label for="category_id">Categoría</label>
    <select id="category_id" name="category_id" required>
        <option value="">-- Seleccionar --</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }} ({{ $cat->zone->name ?? 'Sin zona' }})
            </option>
        @endforeach
    </select>
    @error('category_id')
        <div class="muted">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="barcode">Código de Barras</label>
    <input id="barcode" name="barcode" type="text" value="{{ old('barcode', $product->barcode ?? '') }}" required>
    @error('barcode')
        <div class="muted">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="sku">SKU (opcional)</label>
    <input id="sku" name="sku" type="text" value="{{ old('sku', $product->sku ?? '') }}">
    @error('sku')
        <div class="muted">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="name">Nombre</label>
    <input id="name" name="name" type="text" value="{{ old('name', $product->name ?? '') }}" required>
    @error('name')
        <div class="muted">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="description">Descripcion</label>
    <textarea id="description" name="description" rows="4">{{ old('description', $product->description ?? '') }}</textarea>
    @error('description')
        <div class="muted">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="price">Precio</label>
    <input id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price', $product->price ?? 0) }}">
    @error('price')
        <div class="muted">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="stock_quantity">Stock</label>
    <input id="stock_quantity" name="stock_quantity" type="number" step="0.001" min="0" value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}" required>
    <small class="muted">Unidad: <input id="unit" name="unit" type="text" value="{{ old('unit', $product->unit ?? 'unidad') }}" style="width:120px;"></small>
    @error('stock_quantity')
        <div class="muted">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="status">Estado</label>
    <select id="status" name="status" required>
        <option value="active" {{ old('status', $product->status ?? 'active') == 'active' ? 'selected' : '' }}>Activo</option>
        <option value="inactive" {{ old('status', $product->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactivo</option>
        <option value="discontinued" {{ old('status', $product->status ?? '') == 'discontinued' ? 'selected' : '' }}>Descontinuado</option>
    </select>
    @error('status')
        <div class="muted">{{ $message }}</div>
    @enderror
</div>

<div class="actions">
    <button class="btn" type="submit">{{ $isEdit ? 'Actualizar' : 'Guardar' }}</button>
    <a class="btn secondary" href="{{ route('productos.index') }}">Volver</a>
</div>