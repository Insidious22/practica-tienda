@extends('layouts.app')

@section('content')
    <div class="header">
        <h1 class="title">Editar producto</h1>
    </div>

    <form action="{{ route('productos.update', $product) }}" method="POST">
        @csrf
        @method('PUT')
        @include('products._form', ['product' => $product])
    </form>
@endsection
