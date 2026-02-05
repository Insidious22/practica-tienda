@php $isEdit = isset($category); @endphp

<div class="form-group">
    <label for="zone_id">📍 Zona <span style="color: #ef4444;">*</span></label>
    <select id="zone_id" name="zone_id" required>
        <option value="">-- Seleccionar una zona --</option>
        @foreach($zones as $z)
            <option value="{{ $z->id }}" {{ old('zone_id', $category->zone_id ?? '') == $z->id ? 'selected' : '' }}>{{ $z->name }}</option>
        @endforeach
    </select>
    @error('zone_id')<div class="muted" style="color: #ef4444; font-size: 12px; margin-top: 4px;">⚠️ {{ $message }}</div>@enderror
</div>

<div class="form-row">
    <div class="form-group">
        <label for="name">🏷️ Nombre de la Categoría <span style="color: #ef4444;">*</span></label>
        <input id="name" name="name" type="text" placeholder="Ej: Electrónica" value="{{ old('name', $category->name ?? '') }}" required>
        @error('name')<div class="muted" style="color: #ef4444; font-size: 12px; margin-top: 4px;">⚠️ {{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="code">📊 Código (Opcional)</label>
        <input id="code" name="code" type="text" placeholder="Ej: ELEC-001" value="{{ old('code', $category->code ?? '') }}">
        @error('code')<div class="muted" style="color: #ef4444; font-size: 12px; margin-top: 4px;">⚠️ {{ $message }}</div>@enderror
    </div>
</div>

<div class="form-group">
    <label for="description">📝 Descripción (Opcional)</label>
    <textarea id="description" name="description" placeholder="Detalles sobre esta categoría...">{{ old('description', $category->description ?? '') }}</textarea>
    @error('description')<div class="muted" style="color: #ef4444; font-size: 12px; margin-top: 4px;">⚠️ {{ $message }}</div>@enderror
</div>

<div class="form-actions">
    <button class="btn primary" type="submit" style="gap: 8px;">
        <span>{{ $isEdit ? '💾 Actualizar Categoría' : '➕ Guardar Categoría' }}</span>
    </button>
    <a class="btn secondary" href="{{ route('admin.categorias.index') }}" style="gap: 8px;">
        <span>← Volver a Categorías</span>
    </a>
</div>