@extends('layouts.app')

@section('content')
<div class="header">
    <h1 class="title">Editar Usuario</h1>
</div>

<div style="max-width: 600px;">
    <form action="{{ route('admin.users.update', $user) }}" method="POST" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1f2937;">Nombre Completo</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; box-sizing: border-box;">
            @error('name')
                <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1f2937;">Correo Electrónico</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; box-sizing: border-box;">
            @error('email')
                <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1f2937;">Teléfono (Opcional)</label>
            <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; box-sizing: border-box;">
            @error('phone')
                <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 30px;">
            <label style="display: block; margin-bottom: 12px; font-weight: 500; color: #1f2937;">Asignar Roles</label>
            @forelse ($roles as $role)
                <div style="margin-bottom: 10px;">
                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                    <label for="role_{{ $role->id }}" style="margin: 0; font-weight: normal; color: #1f2937;">{{ $role->name }}</label>
                </div>
            @empty
                <p style="color: #9ca3af;">No hay roles disponibles</p>
            @endforelse
            @error('roles')
                <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: flex; gap: 12px;">
            <button type="submit" class="btn btn-primary" style="flex: 1; padding: 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                Actualizar Usuario
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline" style="flex: 1; padding: 12px; background: white; border: 1px solid #e5e7eb; border-radius: 8px; color: #1f2937; text-decoration: none; font-weight: 600; text-align: center;">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
