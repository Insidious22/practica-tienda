@extends('layouts.app')

@section('content')
    <div class="header">
        <h1 class="title">Productos</h1>
        <a class="btn" href="{{ route('productos.create') }}">Nuevo producto</a>
    </div>

    @if ($products->count() === 0)
        <p class="muted">No hay productos registrados.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}<br><small class="muted">{{ $product->barcode }}</small></td>
                        <td>${{ $product->price ? number_format($product->price, 2) : '-' }}</td>
                        <td><span class="badge">{{ $product->stock_quantity }} {{ $product->unit }}</span><br><small class="muted">{{ $product->category->name ?? 'Sin categoría' }} / {{ $product->category->zone->name ?? 'Sin zona' }}</small></td>
                        <td>
                            <div class="actions">
                                <a class="btn secondary" href="{{ route('productos.show', $product) }}">Ver</a>
                                <a class="btn secondary" href="{{ route('productos.edit', $product) }}">Editar</a>
                                <form action="{{ route('productos.destroy', $product) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn danger" type="submit" onclick="return confirm('Eliminar este producto?')">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 16px;">
            {{ $products->links() }}
        </div>
    @endif
@endsection
