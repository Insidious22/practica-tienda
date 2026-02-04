@extends('layouts.app')

@section('content')
    <div class="header">
        <h1 class="title">Zona: {{ $zone->name }}</h1>
    </div>

    <div>
        <p><strong>Código:</strong> {{ $zone->code }}</p>
        <p><strong>Descripción:</strong> {{ $zone->description }}</p>
        <p><strong>Categorías:</strong></p>
        <ul>
            @foreach($zone->categories as $category)
                <li>{{ $category->name }}</li>
            @endforeach
        </ul>
    </div>

    <a class="btn" href="{{ route('zonas.index') }}">Volver</a>
@endsection