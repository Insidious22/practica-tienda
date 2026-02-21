@extends('layouts.app')

@push('styles')
    @safeVite(['resources/css/admin/users.css'])
@endpush

@section('content')
<div class="header">
    <h1 class="title">Usuarios del Sistema</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary" data-turbo-frame="_top">
        + Nuevo Usuario
    </a>
</div>

@if ($errors->any())
    <div class="alert danger">
        <span>!</span>
        <div>
            <strong>Error</strong>
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
        <span>OK</span>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if (session('error'))
    <div class="alert danger">
        <span>!</span>
        <span>{{ session('error') }}</span>
    </div>
@endif

<turbo-frame id="admin-users-results" class="admin-results-frame">
    <div class="admin-results-skeleton" aria-hidden="true">
        @for($i = 0; $i < 8; $i++)
            <div class="admin-results-skeleton-row">
                <span class="admin-results-skeleton-line admin-results-skeleton-line--md"></span>
                <span class="admin-results-skeleton-line admin-results-skeleton-line--lg"></span>
                <span class="admin-results-skeleton-line admin-results-skeleton-line--sm"></span>
                <span class="admin-results-skeleton-line admin-results-skeleton-line--sm"></span>
                <span class="admin-results-skeleton-line admin-results-skeleton-line--md"></span>
            </div>
        @endfor
    </div>

    <div class="admin-results-content">
        @if ($users->count() > 0)
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Telefono</th>
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
                                <a href="{{ route('admin.users.show', $user) }}" class="action-tag action-tag--info" data-turbo-frame="_top">Ver</a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="action-tag action-tag--warn" data-turbo-frame="_top">Editar</a>
                                @if ($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="admin-inline-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-tag action-tag--danger" onclick="return confirm('Seguro que deseas eliminar este usuario?')">Eliminar</button>
                                    </form>
                                @else
                                    <button class="action-tag action-tag--disabled" type="button">Eliminar</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @include('admin._frame-pagination', ['paginator' => $users, 'frameId' => 'admin-users-results'])
        @else
            <div class="admin-empty-card">
                <p class="admin-empty-text">No hay usuarios registrados.</p>
            </div>
        @endif
    </div>
</turbo-frame>
@endsection
