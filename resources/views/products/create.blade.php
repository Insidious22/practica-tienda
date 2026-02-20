@extends('layouts.app')

@push('styles')
    @safeVite(['resources/css/admin/products.css'])
@endpush

@section('content')
<div class="header">
    <h1 class="title">➕ Crear Nuevo Producto</h1>
</div>

<form action="{{ route('admin.productos.store') }}" method="POST" class="product-form-card">
    @csrf
    @include('products._form')
</form>

<script>
    // Auto-complete SKU from barcode
    document.getElementById('barcode')?.addEventListener('change', function() {
        if (!document.getElementById('sku').value) {
            document.getElementById('sku').value = 'SKU-' + this.value;
        }
    });
</script>

@endsection
