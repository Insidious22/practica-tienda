@extends('layouts.app')

@section('content')
    <div class="header">
        <h1 class="title">Nueva categoría</h1>
    </div>

    <form action="{{ route('categorias.store') }}" method="POST">
        @csrf
        @include('categories._form')
    </form>
@endsection