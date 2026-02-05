@extends('layouts.app')

@section('content')
<div class="header">
    <h1 class="title">✏️ Editar Producto: {{ $product->name }}</h1>
</div>

<form action="{{ route('admin.productos.update', $product) }}" method="POST" style="background: #f9fafb; padding: 20px; border-radius: 8px;">
    @csrf
    @method('PUT')
    @include('products._form', ['product' => $product])
</form>

<script>
    // Show current values info
    console.log('Editando producto:', {
        id: {{ $product->id }},
        nombre: '{{ $product->name }}',
        barcode: '{{ $product->barcode }}'
    });
</script>

@endsection
