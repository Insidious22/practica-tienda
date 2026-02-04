@extends('layouts.app')

@section('content')
    <div class="header">
        <h1 class="title">Categoría: {{ $category->name }}</h1>
    </div>

    <div>
        <p><strong>Zona:</strong> {{ $category->zone->name ?? '-' }}</p>
        <p><strong>Código:</strong> {{ $category->code }}</p>
        <p><strong>Descripción:</strong> {{ $category->description }}</p>
        <p><strong>Productos:</strong></p>
        <ul>
            @foreach($category->products as $product)
                <li>{{ $product->name }} — {{ $product->barcode }}</li>
            @endforeach
        </ul>
    </div>

    <a class="btn" href="{{ route('categorias.index') }}">Volver</a>
@endsection