@extends('layouts.app')

@push('styles')
    @vite(['resources/css/admin/users.css'])
@endpush

@section('content')
<div class="header">
    <h1 class="title">Usuarios del Sistema</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        + Nuevo Usuario
    </a>
</div>

@if ($errors->any())
    <div class="alert danger">
        <span>!</span>
        <div>
            <strong>¡Error!</strong>
            <ul class="alert-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@if (session('success'))
    <div class="alert success">
        <span>✓</span>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if (session('error'))
    <div class="alert danger">
        <span>!</span>
        <span>{{ session('error') }}</span>
    </div>
@endif

@if ($users->count() > 0)
    <table class="admin-table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Teléfono</th>
                <th class="admin-table-actions">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td class="admin-table-muted">{{ $user->email }}</td>
                    <td>
                        @forelse ($user->roles as $role)
                            <span class="role-pill">
                                {{ $role->name }}
                            </span>
                        @empty
                            <span class="role-pill-empty">Sin roles</span>
                        @endforelse
                    </td>
                    <td class="admin-table-muted">{{ $user->phone ?? '-' }}</td>
                    <td class="admin-table-actions">
                        <a href="{{ route('admin.users.show', $user) }}" class="action-tag action-tag--info">Ver</a>
                        <a href="{{ route('admin.users.edit', $user) }}" class="action-tag action-tag--warn">Editar</a>
                        @if ($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="admin-inline-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-tag action-tag--danger" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">Eliminar</button>
                            </form>
                        @else
                            <button class="action-tag action-tag--disabled" type="button">Eliminar</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="admin-table-pagination">
        {{ $users->links() }}
    </div>
@else
    <div class="admin-empty-card">
        <p class="admin-empty-text">No hay usuarios registrados.</p>
    </div>
@endif
@endsection
