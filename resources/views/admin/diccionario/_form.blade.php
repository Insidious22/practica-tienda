@php $isEdit = isset($diccionario); @endphp

<div class="form-row">
    <div class="form-group">
        <label for="tipo">Tipo</label>
        <input type="text" id="tipo" name="tipo" value="{{ old('tipo', $diccionario->tipo ?? '') }}" maxlength="100" required>
    </div>

    <div class="form-group">
        <label for="numero">Numero</label>
        <input type="number" id="numero" name="numero" value="{{ old('numero', $diccionario->numero ?? '') }}" min="1" required>
    </div>
</div>

<div class="form-row">
    <div class="form-group">
        <label for="descripcion">Descripcion</label>
        <input type="text" id="descripcion" name="descripcion" value="{{ old('descripcion', $diccionario->descripcion ?? '') }}" maxlength="150" required>
    </div>

    <div class="form-group">
        <label for="siglas">Siglas</label>
        <input type="text" id="siglas" name="siglas" value="{{ old('siglas', $diccionario->siglas ?? '') }}" minlength="2" maxlength="3" pattern="[A-Z0-9]{2,3}" title="Usa 2 a 3 caracteres en MAYUSCULA (A-Z, 0-9)" required>
        <small class="muted">Formato: 2-3 caracteres, MAYUSCULA, sin tildes. Ej: CED, ACT, KGM.</small>
    </div>
</div>

<div class="form-actions">
    <button type="submit" class="btn primary">{{ $isEdit ? 'Actualizar' : 'Guardar' }}</button>
    <a href="{{ route('admin.diccionario.index') }}" class="btn secondary">Cancelar</a>
</div>
