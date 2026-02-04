@extends('layouts.app')

@section('content')
    <div class="header">
        <h1 class="title">Editar categoría</h1>
    </div>

    <form action="{{ route('categorias.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        @include('categories._form', ['category' => $category])
    </form>
@endsection