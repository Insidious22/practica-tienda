@extends('layouts.app')

@push('styles')
    @safeVite(['resources/css/admin/zones.css'])
@endpush

@section('content')
<div class="header">
    <h1 class="title">➕ Crear Nueva Zona</h1>
</div>

<form action="{{ route('admin.zonas.store') }}" method="POST" class="zone-form-card">
    @csrf
    @include('zones._form')
</form>

@endsection
