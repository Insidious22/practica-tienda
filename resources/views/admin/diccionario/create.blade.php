@extends('layouts.app')

@section('content')
    <div class="header">
        <h2 class="title">Nuevo registro de diccionario</h2>
        <div class="header-actions">
            <a href="{{ route('admin.diccionario.index') }}" class="btn secondary">Volver</a>
        </div>
    </div>

    <form action="{{ route('admin.diccionario.store') }}" method="POST">
        @csrf
        @include('admin.diccionario._form')
    </form>
@endsection
