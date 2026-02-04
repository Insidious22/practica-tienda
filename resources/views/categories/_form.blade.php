@php $isEdit = isset($category); @endphp

<div class="form-group">
    <label for="zone_id">Zona</label>
    <select id="zone_id" name="zone_id" required>
        <option value="">-- Seleccionar --</option>
        @foreach($zones as $z)
            <option value="{{ $z->id }}" {{ old('zone_id', $category->zone_id ?? '') == $z->id ? 'selected' : '' }}>{{ $z->name }}</option>
        @endforeach
    </select>
    @error('zone_id')<div class="muted">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    <label for="name">Nombre</label>
    <input id="name" name="name" type="text" value="{{ old('name', $category->name ?? '') }}" required>
    @error('name')<div class="muted">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    <label for="code">Código (opcional)</label>
    <input id="code" name="code" type="text" value="{{ old('code', $category->code ?? '') }}">
    @error('code')<div class="muted">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    <label for="description">Descripción</label>
    <textarea id="description" name="description" rows="3">{{ old('description', $category->description ?? '') }}</textarea>
    @error('description')<div class="muted">{{ $message }}</div>@enderror
</div>

<div class="actions">
    <button class="btn" type="submit">{{ $isEdit ? 'Actualizar' : 'Guardar' }}</button>
    <a class="btn secondary" href="{{ route('categorias.index') }}">Volver</a>
</div>