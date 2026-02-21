@extends('layouts.app')

@section('content')
<div class="header">
    <h1 class="title">Editar Zona: {{ $zone->name }}</h1>
</div>

<form action="{{ route('admin.zonas.update', $zone) }}" method="POST" class="zone-form-card">
    @csrf
    @method('PUT')
    @include('zones._form', ['zone' => $zone])
</form>

@endsection
