# Guia de Integracion - Modulo Guardias (para rama del otro)

Este documento describe exactamente lo que debe agregar el otro integrante en su rama para luego hacer merge a `practica-tienda`.

## A) Archivos nuevos a crear

### 1) Excepcion

`app/Exceptions/GuardiaYaExisteException.php`
```php
<?php

namespace App\Exceptions;

use Exception;

class GuardiaYaExisteException extends Exception
{
    public function __construct(string $cedula = '')
    {
        $message = "El guardia con cedula {$cedula} ya se encuentra registrado en el sistema.";
        parent::__construct($message);
    }

    public function render()
    {
        return back()->with('error', $this->getMessage())->withInput();
    }
}
```

### 2) Modelos

`app/Models/Guardia.php`
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guardia extends Model
{
    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'tipo_documento',
        'turno',
        'codigo_unico',
        'activo',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
```

`app/Models/InventarioItem.php`
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventarioItem extends Model
{
    protected $fillable = ['nombre', 'codigo_serie', 'cantidad'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
```

`app/Models/Item.php`
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'guardia_id',
        'inventario_item_id',
        'nombre_item',
        'codigo_serie',
    ];

    public function guardia()
    {
        return $this->belongsTo(Guardia::class);
    }

    public function inventarioItem()
    {
        return $this->belongsTo(InventarioItem::class);
    }
}
```

### 3) Controladores

`app/Http/Controllers/Admin/GuardiaController.php`
```php
<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\GuardiaYaExisteException;
use App\Http\Controllers\Controller;
use App\Models\Guardia;
use App\Models\InventarioItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuardiaController extends Controller
{
    public function index()
    {
        $guardias = Guardia::where('activo', true)->orderBy('id', 'desc')->get();
        return view('admin.guardias.index', compact('guardias'));
    }

    public function create()
    {
        $inventarioItems = InventarioItem::where('cantidad', '>', 0)->orderBy('nombre')->get();
        return view('admin.guardias.create', compact('inventarioItems'));
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'tipo_documento' => 'required|string|max:20',
            'turno' => 'required|string|max:20',
            'items' => 'required|array|min:1',
        ];

        if ($request->tipo_documento === 'cedula') {
            $rules['cedula'] = 'required|numeric|max_digits:10|min_digits:8';
        } else {
            $rules['cedula'] = 'required|alpha_num|max:30';
        }

        $request->validate($rules);

        $guardiaExistente = Guardia::where('cedula', $request->cedula)->first();

        if ($guardiaExistente) {
            if ($guardiaExistente->activo) {
                throw new GuardiaYaExisteException($request->cedula);
            }

            return redirect()->back()
                ->withInput()
                ->with('reactivar_id', $guardiaExistente->id)
                ->with('warning', 'El guardia con cedula ' . $request->cedula . ' esta INACTIVO. Deseas reactivarlo?');
        }

        $codigoGenerado = 'G-' . strtoupper(substr(uniqid(), -5));

        DB::transaction(function () use ($request, $codigoGenerado) {
            $guardia = Guardia::create([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'cedula' => $request->cedula,
                'tipo_documento' => $request->tipo_documento,
                'turno' => $request->turno,
                'codigo_unico' => $codigoGenerado,
                'activo' => true,
            ]);

            foreach ($request->items as $inventarioItemId) {
                if (!empty($inventarioItemId)) {
                    $inventarioItem = InventarioItem::find($inventarioItemId);
                    if ($inventarioItem && $inventarioItem->cantidad > 0) {
                        $guardia->items()->create([
                            'inventario_item_id' => $inventarioItemId,
                            'nombre_item' => $inventarioItem->nombre,
                            'codigo_serie' => $inventarioItem->codigo_serie,
                        ]);
                        $inventarioItem->decrement('cantidad');
                    }
                }
            }
        });

        return redirect()->route('admin.guardias.create')->with('success', 'Guardia guardado con codigo: ' . $codigoGenerado);
    }

    public function show(string $id)
    {
        $guardia = Guardia::with('items.inventarioItem')->findOrFail($id);
        $inventarioItems = InventarioItem::where('cantidad', '>', 0)->orderBy('nombre')->get();
        return view('admin.guardias.show', compact('guardia', 'inventarioItems'));
    }

    public function edit(string $id)
    {
        $guardia = Guardia::findOrFail($id);
        return view('admin.guardias.edit', compact('guardia'));
    }

    public function update(Request $request, string $id)
    {
        $guardia = Guardia::findOrFail($id);
        $guardia->update($request->only(['nombre', 'apellido', 'cedula', 'tipo_documento', 'turno']));

        return redirect()->route('admin.guardias.index')->with('success', 'Datos actualizados con exito.');
    }

    public function destroy(string $id)
    {
        $guardia = Guardia::with('items.inventarioItem')->findOrFail($id);

        DB::transaction(function () use ($guardia) {
            $guardia->activo = false;
            $guardia->save();

            foreach ($guardia->items as $item) {
                if ($item->inventarioItem) {
                    $item->inventarioItem->increment('cantidad');
                }
                $item->delete();
            }
        });

        return redirect()->route('admin.guardias.index')->with('success', 'Guardia marcado como INACTIVO y equipo devuelto.');
    }

    public function addItem(Request $request, string $id)
    {
        $guardia = Guardia::findOrFail($id);
        $request->validate([
            'inventario_item_id' => 'required|integer|exists:inventario_items,id',
        ]);

        $inventarioItemId = $request->input('inventario_item_id');
        $inventarioItem = InventarioItem::findOrFail($inventarioItemId);

        if ($inventarioItem->cantidad <= 0) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Item no disponible'], 400);
            }
            return redirect()->route('admin.guardias.show', $guardia->id)->with('error', 'Item no disponible');
        }

        $existingItem = $guardia->items()
            ->where('inventario_item_id', $inventarioItemId)
            ->exists();

        if ($existingItem) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Este item ya esta asignado al guardia'], 400);
            }
            return redirect()->route('admin.guardias.show', $guardia->id)->with('error', 'Este item ya esta asignado al guardia');
        }

        DB::transaction(function () use ($guardia, $inventarioItem) {
            $guardia->items()->create([
                'inventario_item_id' => $inventarioItem->id,
                'nombre_item' => $inventarioItem->nombre,
                'codigo_serie' => $inventarioItem->codigo_serie,
            ]);
            $inventarioItem->decrement('cantidad');
        });

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Item agregado correctamente']);
        }

        return redirect()->route('admin.guardias.show', $guardia->id)->with('success', 'Item agregado correctamente.');
    }

    public function reactivar(Request $request, string $id)
    {
        $guardia = Guardia::findOrFail($id);
        $guardia->activo = true;
        $guardia->save();

        return redirect()->route('admin.guardias.create')
            ->with('success', 'El guardia ' . $guardia->nombre . ' ' . $guardia->apellido . ' ha sido reactivado exitosamente.');
    }
}
```

`app/Http/Controllers/Admin/ItemController.php`
```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function destroy(string $id)
    {
        $item = Item::with('inventarioItem')->findOrFail($id);
        $guardiaId = $item->guardia_id;

        DB::transaction(function () use ($item) {
            if ($item->inventarioItem) {
                $item->inventarioItem->increment('cantidad');
            }
            $item->delete();
        });

        return redirect()->route('admin.guardias.show', $guardiaId)
            ->with('success', 'Item removido correctamente. Cantidad devuelta al inventario.');
    }
}
```

### 4) Migraciones

`database/migrations/2026_02_10_120000_create_guardias_table.php`
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guardias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('tipo_documento')->default('cedula');
            $table->string('cedula')->unique();
            $table->string('turno');
            $table->string('codigo_unico')->unique()->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guardias');
    }
};
```

`database/migrations/2026_02_10_120100_create_inventario_items_table.php`
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventario_items', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codigo_serie')->unique();
            $table->integer('cantidad')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventario_items');
    }
};
```

`database/migrations/2026_02_10_120200_create_items_table.php`
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guardia_id')->constrained('guardias')->onDelete('cascade');
            $table->foreignId('inventario_item_id')->constrained('inventario_items')->onDelete('cascade');
            $table->string('nombre_item')->nullable();
            $table->string('codigo_serie')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
```

### 5) Vistas

Crear carpeta `resources/views/admin/guardias` y dentro:

`index.blade.php`
```blade
@extends('layouts.app')

@section('content')
    <div class="header">
        <h2 class="title">Guardias</h2>
        <div class="header-actions">
            <a href="{{ route('admin.guardias.create') }}" class="btn primary">Nuevo guardia</a>
        </div>
    </div>

    @if ($guardias->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">Guardias</div>
            <p class="empty-state-text">No hay guardias registrados.</p>
            <a href="{{ route('admin.guardias.create') }}" class="btn primary">Registrar guardia</a>
        </div>
    @else
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Cedula</th>
                <th>Turno</th>
                <th>Codigo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($guardias as $guardia)
                <tr>
                    <td>{{ $guardia->id }}</td>
                    <td>{{ $guardia->nombre }} {{ $guardia->apellido }}</td>
                    <td>{{ $guardia->cedula }}</td>
                    <td>{{ $guardia->turno }}</td>
                    <td>{{ $guardia->codigo_unico ?? '-' }}</td>
                    <td>
                        @if($guardia->activo)
                            <span class="badge success">Activo</span>
                        @else
                            <span class="badge danger">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('admin.guardias.show', $guardia) }}" class="btn secondary">Ver</a>
                            <a href="{{ route('admin.guardias.edit', $guardia) }}" class="btn secondary">Editar</a>
                            <form action="{{ route('admin.guardias.destroy', $guardia) }}" method="POST" onsubmit="return confirm('Marcar guardia como inactivo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn danger">Inactivar</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
```

`create.blade.php`
```blade
@extends('layouts.app')

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
            <form action="{{ route('admin.guardias.reactivar', session('reactivar_id')) }}" method="POST" style="margin-left: auto;">
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
                    <option value="cedula" @selected(old('tipo_documento') === 'cedula')>Cedula</option>
                    <option value="pasaporte" @selected(old('tipo_documento') === 'pasaporte')>Pasaporte</option>
                    <option value="otro" @selected(old('tipo_documento') === 'otro')>Otro</option>
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
                    <option value="Manana" @selected(old('turno') === 'Manana')>Manana</option>
                    <option value="Tarde" @selected(old('turno') === 'Tarde')>Tarde</option>
                    <option value="Noche" @selected(old('turno') === 'Noche')>Noche</option>
                </select>
            </div>
        </div>

        <div class="header" style="margin-top: 20px;">
            <h3 class="title" style="font-size: 18px;">Equipamiento</h3>
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
                <div class="form-group" style="display: flex; align-items: flex-end;">
                    <button type="button" id="add-item-btn" class="btn success">Agregar item</button>
                </div>
            </div>

            <table class="table" id="items-table" style="display: none;">
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
            if (tipoDocumento.value === 'cedula') {
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
                        <button type="button" class="btn danger btn-delete" data-index="${rowIndex}">Eliminar</button>
                    </td>
                `;
                tbody.appendChild(row);
                table.style.display = 'table';

                row.querySelector('.btn-delete').addEventListener('click', function () {
                    const index = parseInt(this.getAttribute('data-index'));
                    items.splice(index, 1);
                    tbody.deleteRow(index);
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
```

`edit.blade.php`
```blade
@extends('layouts.app')

@section('content')
    <div class="header">
        <h2 class="title">Editar Guardia</h2>
        <div class="header-actions">
            <a href="{{ route('admin.guardias.index') }}" class="btn secondary">Volver</a>
        </div>
    </div>

    <form action="{{ route('admin.guardias.update', $guardia) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $guardia->nombre) }}" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" value="{{ old('apellido', $guardia->apellido) }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="tipo_documento">Tipo de documento</label>
                <select id="tipo_documento" name="tipo_documento" required>
                    <option value="cedula" @selected(old('tipo_documento', $guardia->tipo_documento) === 'cedula')>Cedula</option>
                    <option value="pasaporte" @selected(old('tipo_documento', $guardia->tipo_documento) === 'pasaporte')>Pasaporte</option>
                    <option value="otro" @selected(old('tipo_documento', $guardia->tipo_documento) === 'otro')>Otro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="cedula">Cedula/Documento</label>
                <input type="text" id="cedula" name="cedula" value="{{ old('cedula', $guardia->cedula) }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="turno">Turno</label>
                <select id="turno" name="turno" required>
                    <option value="Manana" @selected(old('turno', $guardia->turno) === 'Manana')>Manana</option>
                    <option value="Tarde" @selected(old('turno', $guardia->turno) === 'Tarde')>Tarde</option>
                    <option value="Noche" @selected(old('turno', $guardia->turno) === 'Noche')>Noche</option>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn primary">Guardar cambios</button>
            <a href="{{ route('admin.guardias.index') }}" class="btn secondary">Cancelar</a>
        </div>
    </form>
@endsection
```

`show.blade.php`
```blade
@extends('layouts.app')

@section('content')
    <div class="header">
        <h2 class="title">Detalle de Guardia</h2>
        <div class="header-actions">
            <a href="{{ route('admin.guardias.index') }}" class="btn secondary">Volver</a>
            <a href="{{ route('admin.guardias.edit', $guardia) }}" class="btn primary">Editar</a>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Nombre</label>
            <div>{{ $guardia->nombre }} {{ $guardia->apellido }}</div>
        </div>
        <div class="form-group">
            <label>Cedula</label>
            <div>{{ $guardia->cedula }}</div>
        </div>
        <div class="form-group">
            <label>Turno</label>
            <div>{{ $guardia->turno }}</div>
        </div>
        <div class="form-group">
            <label>Codigo</label>
            <div>{{ $guardia->codigo_unico ?? '-' }}</div>
        </div>
    </div>

    <div class="header" style="margin-top: 20px;">
        <h3 class="title" style="font-size: 18px;">Equipamiento asignado</h3>
    </div>

    @if ($guardia->items->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">Items</div>
            <p class="empty-state-text">Este guardia no tiene items asignados.</p>
        </div>
    @else
        <table class="table">
            <thead>
            <tr>
                <th>Item</th>
                <th>Codigo</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($guardia->items as $item)
                <tr>
                    <td>{{ $item->nombre_item ?? ($item->inventarioItem->nombre ?? '-') }}</td>
                    <td>{{ $item->codigo_serie ?? ($item->inventarioItem->codigo_serie ?? '-') }}</td>
                    <td>
                        <form action="{{ route('admin.guardias.items.destroy', $item) }}" method="POST" onsubmit="return confirm('Quitar este item?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn danger">Quitar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

    <div class="header" style="margin-top: 20px;">
        <h3 class="title" style="font-size: 18px;">Agregar item</h3>
    </div>

    <form action="{{ route('admin.guardias.addItem', $guardia) }}" method="POST" class="form-row">
        @csrf
        <div class="form-group">
            <label for="inventario_item_id">Inventario</label>
            <select id="inventario_item_id" name="inventario_item_id" required>
                @foreach ($inventarioItems as $inv)
                    <option value="{{ $inv->id }}">{{ $inv->nombre }} ({{ $inv->cantidad }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group" style="display: flex; align-items: flex-end;">
            <button type="submit" class="btn success">Agregar</button>
        </div>
    </form>
@endsection
```

## B) Cambios en archivos existentes

### 1) Rutas en `routes/web.php` (dentro del grupo admin)
```php
use App\Http\Controllers\Admin\GuardiaController as AdminGuardiaController;
use App\Http\Controllers\Admin\ItemController as AdminItemController;

Route::patch('guardias/{id}/reactivar', [AdminGuardiaController::class, 'reactivar'])->name('guardias.reactivar');
Route::post('guardias/{guardia}/items', [AdminGuardiaController::class, 'addItem'])->name('guardias.addItem');
Route::delete('guardia-items/{id}', [AdminItemController::class, 'destroy'])->name('guardias.items.destroy');
Route::resource('guardias', AdminGuardiaController::class)->names('guardias');
```

### 2) Sidebar en `resources/views/layouts/app.blade.php`
```blade
<a href="{{ route('admin.guardias.index') }}" class="@if(str_starts_with(Route::currentRouteName(), 'admin.guardias')) active @endif">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 10-8 0v1a4 4 0 108 0V7z"></path>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14a7 7 0 00-7 7v1h14v-1a7 7 0 00-7-7z"></path>
    </svg>
    Guardias
</a>
```

## C) Notas
- Despues de merge, ejecutar migraciones.
- Cargar inventario inicial en `inventario_items` antes de crear guardias.
