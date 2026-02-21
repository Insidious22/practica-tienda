@extends('layouts.app')

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
