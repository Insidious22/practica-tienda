@extends('layouts.app')

@section('content')
    <div class="header">
        <h1 class="title">Editar zona</h1>
    </div>

    <form action="{{ route('zonas.update', $zone) }}" method="POST">
        @csrf
        @method('PUT')
        @include('zones._form', ['zone' => $zone])
    </form>
@endsection
