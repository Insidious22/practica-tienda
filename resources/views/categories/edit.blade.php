@extends('layouts.app')

@section('content')
<div class="header">
    <h1 class="title">✏️ Editar Categoría: {{ $category->name }}</h1>
</div>

<form action="{{ route('admin.categorias.update', $category) }}" method="POST" style="background: #f9fafb; padding: 20px; border-radius: 8px;">
    @csrf
    @method('PUT')
    @include('categories._form', ['category' => $category])
</form>

@endsection