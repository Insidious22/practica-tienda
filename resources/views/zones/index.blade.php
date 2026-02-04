@extends('layouts.app')

@section('content')
    <div class="header">
        <h1 class="title">Zonas</h1>
        <a class="btn" href="{{ route('zonas.create') }}">Nueva zona</a>
    </div>

    @if ($zones->count() === 0)
        <p class="muted">No hay zonas registradas.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($zones as $zone)
                    <tr>
                        <td>{{ $zone->id }}</td>
                        <td>{{ $zone->code }}</td>
                        <td>{{ $zone->name }}</td>
                        <td>{{ $zone->description }}</td>
                        <td>
                            <div class="actions">
                                <a class="btn secondary" href="{{ route('zonas.show', $zone) }}">Ver</a>
                                <a class="btn secondary" href="{{ route('zonas.edit', $zone) }}">Editar</a>
                                <form action="{{ route('zonas.destroy', $zone) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn danger" type="submit" onclick="return confirm('Eliminar esta zona?')">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 16px;">
            {{ $zones->links() }}
        </div>
    @endif
@endsection
