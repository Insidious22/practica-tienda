@php $isEdit = isset($zone); @endphp

<div class="form-group">
    <label for="code">Código</label>
    <input id="code" name="code" type="text" value="{{ old('code', $zone->code ?? '') }}" required>
    @error('code')<div class="muted">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    <label for="name">Nombre</label>
    <input id="name" name="name" type="text" value="{{ old('name', $zone->name ?? '') }}" required>
    @error('name')<div class="muted">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    <label for="description">Descripción</label>
    <textarea id="description" name="description" rows="3">{{ old('description', $zone->description ?? '') }}</textarea>
    @error('description')<div class="muted">{{ $message }}</div>@enderror
</div>

<div class="actions">
    <button class="btn" type="submit">{{ $isEdit ? 'Actualizar' : 'Guardar' }}</button>
    <a class="btn secondary" href="{{ route('zonas.index') }}">Volver</a>
</div>