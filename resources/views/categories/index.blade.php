@extends('layouts.app')

@section('content')
    <div class="header">
        <h1 class="title">Categorías</h1>
        <a class="btn" href="{{ route('categorias.create') }}">Nueva categoría</a>
    </div>

    @if ($categories->count() === 0)
        <p class="muted">No hay categorías registradas.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Zona</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->zone->name ?? '-' }}</td>
                        <td>{{ $category->description }}</td>
                        <td>
                            <div class="actions">
                                <a class="btn secondary" href="{{ route('categorias.show', $category) }}">Ver</a>
                                <a class="btn secondary" href="{{ route('categorias.edit', $category) }}">Editar</a>
                                <form action="{{ route('categorias.destroy', $category) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn danger" type="submit" onclick="return confirm('Eliminar esta categoría?')">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 16px;">
            {{ $categories->links() }}
        </div>
    @endif
@endsection