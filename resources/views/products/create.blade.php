@extends('layouts.app')

@section('content')
    <div class="header">
        <h1 class="title">Nuevo producto</h1>
    </div>

    <form action="{{ route('productos.store') }}" method="POST">
        @csrf
        @include('products._form')
    </form>
@endsection
