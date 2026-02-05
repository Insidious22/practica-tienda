@extends('layouts.app')

@section('content')
<div class="header">
    <h1 class="title">➕ Crear Nueva Zona</h1>
</div>

<form action="{{ route('admin.zonas.store') }}" method="POST" style="background: #f9fafb; padding: 20px; border-radius: 8px;">
    @csrf
    @include('zones._form')
</form>

@endsection
