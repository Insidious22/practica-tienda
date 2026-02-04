@extends('layouts.app')

@section('content')
    <div class="header">
        <h1 class="title">Nueva zona</h1>
    </div>

    <form action="{{ route('zonas.store') }}" method="POST">
        @csrf
        @include('zones._form')
    </form>
@endsection
