@extends('layouts.app')

@section('content')
    <div class="header">
        <h1 class="title">Detalle del producto</h1>
        <div class="actions">
            <a class="btn secondary" href="{{ route('productos.edit', $product) }}">Editar</a>
            <a class="btn secondary" href="{{ route('productos.index') }}">Volver</a>
        </div>
    </div>

    <p><strong>Nombre:</strong> {{ $product->name }}</p>
    <p><strong>Descripcion:</strong> {{ $product->description ?: 'Sin descripcion' }}</p>
    <p><strong>Precio:</strong> {{ $product->price ? ('$' . number_format($product->price, 2)) : '-' }}</p>
    <p><strong>Stock:</strong> {{ $product->stock_quantity }} {{ $product->unit }}</p>
    <p><strong>Código de Barras:</strong> {{ $product->barcode }}</p>
    <p><strong>Categoría:</strong> {{ $product->category->name ?? '-' }}</p>
    <p><strong>Zona:</strong> {{ $product->category->zone->name ?? '-' }}</p>
@endsection
