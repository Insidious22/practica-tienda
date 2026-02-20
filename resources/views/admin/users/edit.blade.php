@extends('layouts.app')

@push('styles')
    @safeVite(['resources/css/admin/users.css'])
@endpush

@section('content')
<div class="header">
    <h1 class="title">Editar Usuario</h1>
</div>

<div class="admin-form-container">
    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="admin-form-card">
        @csrf
        @method('PUT')

        <div class="admin-form-group">
            <label class="admin-form-label">Nombre Completo</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="admin-form-input">
            @error('name')
                <span class="admin-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form-group">
            <label class="admin-form-label">Correo Electrónico</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="admin-form-input">
            @error('email')
                <span class="admin-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form-group">
            <label class="admin-form-label">Teléfono (Opcional)</label>
            <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="admin-form-input">
            @error('phone')
                <span class="admin-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form-group admin-form-group--lg">
            <label class="admin-form-label">Asignar Roles</label>
            @forelse ($roles as $role)
                <div class="role-option">
                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                    <label for="role_{{ $role->id }}" class="admin-form-checkbox-label">{{ $role->name }}</label>
                </div>
            @empty
                <p class="role-empty">No hay roles disponibles</p>
            @endforelse
            @error('roles')
                <span class="admin-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form-actions">
            <button type="submit" class="btn btn-primary admin-form-button">
                Actualizar Usuario
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline admin-form-button">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
