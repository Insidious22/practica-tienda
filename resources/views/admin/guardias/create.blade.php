@extends('layouts.app')

@push('styles')
    @safeVite(['resources/css/admin/guardias.css'])
@endpush

@section('content')
    <div class="header">
        <h2 class="title">Registrar Guardia</h2>
        <div class="header-actions">
            <a href="{{ route('admin.guardias.index') }}" class="btn secondary">Volver</a>
        </div>
    </div>

    @if (session('reactivar_id'))
        <div class="alert warning">
            <span>!</span>
            <span>{{ session('warning') }}</span>
            <form action="{{ route('admin.guardias.reactivar', session('reactivar_id')) }}" method="POST" class="alert-action">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn secondary">Reactivar</button>
            </form>
        </div>
    @endif

    @if (session('error'))
        <div class="alert danger">
            <span>!</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <form action="{{ route('admin.guardias.store') }}" method="POST" id="form-guardia">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="tipo_documento">Tipo de documento</label>
                <select id="tipo_documento" name="tipo_documento" required>
                    @foreach ($tiposDocumento as $tipo)
                        <option value="{{ $tipo->siglas }}" @selected(old('tipo_documento') === $tipo->siglas)>{{ $tipo->descripcion }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="cedula">Cedula/Documento</label>
                <input type="text" id="cedula" name="cedula" value="{{ old('cedula') }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="turno">Turno</label>
                <select id="turno" name="turno" required>
                    @foreach ($turnos as $turno)
                        <option value="{{ $turno->siglas }}" @selected(old('turno') === $turno->siglas)>{{ $turno->descripcion }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="header section-header">
            <h3 class="title section-title">Equipamiento</h3>
        </div>

        @if ($inventarioItems->isEmpty())
            <div class="alert warning">
                <span>!</span>
                <span>No hay equipamiento disponible. Agrega items al inventario.</span>
            </div>
        @else
            <div class="form-row">
                <div class="form-group">
                    <label for="inventario-select">Seleccionar equipamiento</label>
                    <select id="inventario-select">
                        <option value="">-- Selecciona un item --</option>
                        @foreach ($inventarioItems as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->nombre }} ({{ $item->cantidad }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group form-group--align-end">
                    <button type="button" id="add-item-btn" class="btn success">Agregar item</button>
                </div>
            </div>

            <table class="table table-hidden" id="items-table">
                <thead>
                <tr>
                    <th>Item</th>
                    <th>Codigo</th>
                    <th>Accion</th>
                </tr>
                </thead>
                <tbody id="items-tbody"></tbody>
            </table>
        @endif

        <div class="form-actions">
            <button type="submit" class="btn primary" id="submit-btn">Registrar</button>
            <button type="reset" class="btn secondary">Cancelar</button>
        </div>
    </form>

    <script>
        const items = [];
        const addBtn = document.getElementById('add-item-btn');
        const table = document.getElementById('items-table');
        const tbody = document.getElementById('items-tbody');

        const tipoDocumento = document.getElementById('tipo_documento');
        const cedulaInput = document.getElementById('cedula');

        tipoDocumento.addEventListener('change', () => {
            cedulaInput.value = '';
            if (tipoDocumento.value === 'CED') {
                cedulaInput.maxLength = 10;
            } else {
                cedulaInput.maxLength = 30;
            }
        });

        if (addBtn) {
            addBtn.addEventListener('click', () => {
                const select = document.getElementById('inventario-select');
                const itemId = select.value;
                const selectedOption = select.options[select.selectedIndex];
                const itemText = selectedOption.text;
                const nombre = itemText.split('(')[0].trim();

                if (!itemId) {
                    alert('Selecciona un item');
                    return;
                }
                if (items.find(i => i.id === itemId)) {
                    alert('Este item ya esta agregado');
                    return;
                }

                items.push({ id: itemId, nombre });
                const rowIndex = items.length - 1;
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${nombre}</td>
                    <td>Del inventario</td>
                    <td>
                        <button type="button" class="btn danger btn-delete" data-id="${itemId}">Eliminar</button>
                    </td>
                `;
                tbody.appendChild(row);
                table.style.display = 'table';

                row.querySelector('.btn-delete').addEventListener('click', function () {
                    const idToRemove = this.getAttribute('data-id');
                    const itemIndex = items.findIndex(i => i.id === idToRemove);
                    if (itemIndex > -1) {
                        items.splice(itemIndex, 1);
                    }
                    this.closest('tr').remove();

                    if (items.length === 0) {
                        table.style.display = 'none';
                    }
                    updateHiddenInputs();
                });

                select.value = '';
                updateHiddenInputs();
            });
        }

        function updateHiddenInputs() {
            const form = document.getElementById('form-guardia');
            const oldInputs = form.querySelectorAll('input[name^="items"]');
            oldInputs.forEach(input => input.remove());

            items.forEach((item, index) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `items[${index}]`;
                input.value = item.id;
                form.appendChild(input);
            });
        }

        document.getElementById('submit-btn').addEventListener('click', function (e) {
            if (items.length === 0) {
                e.preventDefault();
                alert('Debe asignar al menos un item');
                return false;
            }
            updateHiddenInputs();
        });
    </script>
@endsection
