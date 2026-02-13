@extends('layouts.app')

@push('styles')
    @vite(['resources/css/admin/users.css'])
@endpush

@section('content')
<div class="header">
    <h1 class="title">Crear Nuevo Usuario</h1>
</div>

<div class="admin-form-container">
    <form action="{{ route('admin.users.store') }}" method="POST" class="admin-form-card">
        @csrf

        <div class="admin-form-group">
            <label class="admin-form-label">Nombre Completo</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="admin-form-input">
            @error('name')
                <span class="admin-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form-group">
            <label class="admin-form-label">Correo Electrónico</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="admin-form-input">
            @error('email')
                <span class="admin-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form-group">
            <label class="admin-form-label">Teléfono (Opcional)</label>
            <input type="tel" name="phone" value="{{ old('phone') }}" class="admin-form-input">
            @error('phone')
                <span class="admin-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form-group">
            <label class="admin-form-label">Contraseña</label>
            <input type="password" name="password" required class="admin-form-input">
            <small class="admin-form-helper">Mínimo 8 caracteres</small>
            @error('password')
                <span class="admin-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form-group">
            <label class="admin-form-label">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" required class="admin-form-input">
        </div>

        <div class="admin-form-group admin-form-group--lg">
            <label class="admin-form-label">Asignar Roles</label>
            @forelse ($roles as $role)
                <div class="role-option">
                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}" {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
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
                Crear Usuario
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline admin-form-button">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
