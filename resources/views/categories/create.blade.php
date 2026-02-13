@extends('layouts.app')

@push('styles')
    @vite(['resources/css/admin/categories.css'])
@endpush

@section('content')
<div class="header">
    <h1 class="title">➕ Crear Nueva Categoría</h1>
</div>

<form action="{{ route('admin.categorias.store') }}" method="POST" class="category-form">
    @csrf
    @include('categories._form')
</form>

@endsection
