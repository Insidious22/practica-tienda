@extends('layouts.app')

@section('content')
<div class="header">
    <h1 class="title">Editar Producto: {{ $product->name }}</h1>
</div>

<div
    id="edit-product-meta"
    data-id="{{ $product->id }}"
    data-nombre="{{ e($product->name) }}"
    data-barcode="{{ e($product->barcode) }}"
></div>

<form action="{{ route('admin.productos.update', $product) }}" method="POST" class="product-form-card">
    @csrf
    @method('PUT')
    @include('products._form', ['product' => $product])
</form>

<script>
    // Show current values info
    const productMeta = document.getElementById('edit-product-meta');

    if (productMeta) {
        console.log('Editando producto:', {
            id: Number(productMeta.dataset.id || 0),
            nombre: productMeta.dataset.nombre || '',
            barcode: productMeta.dataset.barcode || ''
        });
    }

</script>

@endsection
