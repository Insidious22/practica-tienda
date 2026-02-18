@php $isEdit = isset($diccionario); @endphp
@php $tiposConocidos = \App\Models\Diccionario::tiposConocidos(); @endphp

<div class="form-row">
    <div class="form-group">
        <label for="tabla">Tipo (tabla)</label>
        <input type="text" id="tabla" name="tabla" value="{{ old('tabla', $diccionario->tabla ?? '') }}" maxlength="255" list="tipos-conocidos" required>
        <datalist id="tipos-conocidos">
            @foreach ($tiposConocidos as $codigo => $nombre)
                <option value="{{ $codigo }}">{{ $nombre }}</option>
            @endforeach
        </datalist>
        <small class="muted">Se guarda en mayusculas. Ej: GTD, GTR, CTD, GIRNEG.</small>
    </div>

    <div class="form-group">
        <label for="orden">Orden</label>
        <input type="number" id="orden" name="orden" value="{{ old('orden', $diccionario->orden ?? '') }}" min="1" required>
    </div>
</div>

<div class="form-row">
    <div class="form-group">
        <label for="descripcion">Descripcion</label>
        <input type="text" id="descripcion" name="descripcion" value="{{ old('descripcion', $diccionario->descripcion ?? '') }}" maxlength="255" required>
    </div>

    <div class="form-group">
        <label for="valor">Valor (codigo corto)</label>
        <input type="text" id="valor" name="valor" value="{{ old('valor', $diccionario->valor ?? '') }}" maxlength="255">
        <small class="muted">Opcional. Si lo dejas vacio se autogenera desde la descripcion.</small>
    </div>
</div>

<div class="form-row">
    <div class="form-group">
        <label for="estado">Estado</label>
        <select id="estado" name="estado" required>
            <option value="A" @selected(old('estado', $diccionario->estado ?? 'A') === 'A')>A</option>
            <option value="I" @selected(old('estado', $diccionario->estado ?? 'A') === 'I')>I</option>
        </select>
    </div>

    <div class="form-group">
        <label for="id_cliente">ID Cliente</label>
        <input type="number" id="id_cliente" name="id_cliente" value="{{ old('id_cliente', $diccionario->id_cliente ?? '') }}" min="1">
    </div>
</div>

<div class="form-actions">
    <button type="submit" class="btn primary">{{ $isEdit ? 'Actualizar' : 'Guardar' }}</button>
    <a href="{{ route('admin.diccionario.index') }}" class="btn secondary">Cancelar</a>
</div>
