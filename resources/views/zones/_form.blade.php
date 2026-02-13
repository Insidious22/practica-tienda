@php $isEdit = isset($zone); @endphp

<div class="form-row">
    <div class="form-group mb-3">
        <label for="code">📊 Código de Zona <span class="zone-required">*</span></label>
        <input id="code" name="code" type="text" class="form-control" placeholder="Ej: Z-001" value="{{ old('code', $zone->code ?? '') }}" required>
        @error('code')<div class="muted zone-error">⚠️ {{ $message }}</div>@enderror
    </div>

    <div class="form-group mb-3">
        <label for="name">📍 Nombre de la Zona <span class="zone-required">*</span></label>
        <input id="name" name="name" type="text" class="form-control" placeholder="Ej: Norte" value="{{ old('name', $zone->name ?? '') }}" required>
        @error('name')<div class="muted zone-error">⚠️ {{ $message }}</div>@enderror
    </div>
</div>

<div class="form-group mb-3">
    <label for="description">📝 Descripción (Opcional)</label>
    <textarea id="description" name="description" class="form-control" placeholder="Detalles sobre esta zona...">{{ old('description', $zone->description ?? '') }}</textarea>
    @error('description')<div class="muted zone-error">⚠️ {{ $message }}</div>@enderror
</div>

<div class="form-actions zone-form-actions">
    <button class="btn btn-primary zone-action-btn" type="submit">
        <span>{{ $isEdit ? '💾 Actualizar Zona' : '➕ Guardar Zona' }}</span>
    </button>
    <a class="btn btn-secondary zone-action-btn" href="{{ route('admin.zonas.index') }}">
        <span>← Volver a Zonas</span>
    </a>
</div>
