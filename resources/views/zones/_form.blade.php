@php $isEdit = isset($zone); @endphp

<div class="form-row">
    <div class="form-group">
        <label for="code">📊 Código de Zona <span style="color: #ef4444;">*</span></label>
        <input id="code" name="code" type="text" placeholder="Ej: Z-001" value="{{ old('code', $zone->code ?? '') }}" required>
        @error('code')<div class="muted" style="color: #ef4444; font-size: 12px; margin-top: 4px;">⚠️ {{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="name">📍 Nombre de la Zona <span style="color: #ef4444;">*</span></label>
        <input id="name" name="name" type="text" placeholder="Ej: Norte" value="{{ old('name', $zone->name ?? '') }}" required>
        @error('name')<div class="muted" style="color: #ef4444; font-size: 12px; margin-top: 4px;">⚠️ {{ $message }}</div>@enderror
    </div>
</div>

<div class="form-group">
    <label for="description">📝 Descripción (Opcional)</label>
    <textarea id="description" name="description" placeholder="Detalles sobre esta zona...">{{ old('description', $zone->description ?? '') }}</textarea>
    @error('description')<div class="muted" style="color: #ef4444; font-size: 12px; margin-top: 4px;">⚠️ {{ $message }}</div>@enderror
</div>

<div class="form-actions">
    <button class="btn primary" type="submit" style="gap: 8px;">
        <span>{{ $isEdit ? '💾 Actualizar Zona' : '➕ Guardar Zona' }}</span>
    </button>
    <a class="btn secondary" href="{{ route('admin.zonas.index') }}" style="gap: 8px;">
        <span>← Volver a Zonas</span>
    </a>
</div>
