@extends('layouts.app')

@section('content')
<div class="header">
    <h1 class="title">➕ Crear Nueva Categoría</h1>
</div>

<form action="{{ route('admin.categorias.store') }}" method="POST" style="background: #f9fafb; padding: 20px; border-radius: 8px;">
    @csrf
    @include('categories._form')
</form>

@endsection
