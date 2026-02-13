@extends('layouts.app')

@push('styles')
    @vite(['resources/css/admin/categories.css'])
@endpush

@section('content')
<div class="header">
    <h1 class="title">✏️ Editar Categoría: {{ $category->name }}</h1>
</div>

<form action="{{ route('admin.categorias.update', $category) }}" method="POST" class="category-form">
    @csrf
    @method('PUT')
    @include('categories._form', ['category' => $category])
</form>

@endsection
