@extends('layouts.app')

@section('content')
<div class="header">
    <h1 class="title">Usuarios del Sistema</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary" style="padding: 10px 20px; text-decoration: none;">
        + Nuevo Usuario
    </a>
</div>

@if ($errors->any())
    <div class="alert danger" style="margin-bottom: 20px;">
        <span>!</span>
        <div>
            <strong>¡Error!</strong>
            <ul style="margin: 5px 0 0 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@if (session('success'))
    <div class="alert success" style="margin-bottom: 20px;">
        <span>✓</span>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if (session('error'))
    <div class="alert danger" style="margin-bottom: 20px;">
        <span>!</span>
        <span>{{ session('error') }}</span>
    </div>
@endif

@if ($users->count() > 0)
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                <th style="padding: 15px; text-align: left; font-weight: 600; color: #1f2937;">Nombre</th>
                <th style="padding: 15px; text-align: left; font-weight: 600; color: #1f2937;">Email</th>
                <th style="padding: 15px; text-align: left; font-weight: 600; color: #1f2937;">Roles</th>
                <th style="padding: 15px; text-align: left; font-weight: 600; color: #1f2937;">Teléfono</th>
                <th style="padding: 15px; text-align: center; font-weight: 600; color: #1f2937;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <td style="padding: 15px; color: #1f2937; font-weight: 500;">{{ $user->name }}</td>
                    <td style="padding: 15px; color: #6b7280;">{{ $user->email }}</td>
                    <td style="padding: 15px;">
                        @forelse ($user->roles as $role)
                            <span style="display: inline-block; background: #e0e7ff; color: #4f46e5; padding: 4px 8px; border-radius: 4px; font-size: 12px; margin-right: 4px;">
                                {{ $role->name }}
                            </span>
                        @empty
                            <span style="color: #9ca3af;">Sin roles</span>
                        @endforelse
                    </td>
                    <td style="padding: 15px; color: #6b7280;">{{ $user->phone ?? '-' }}</td>
                    <td style="padding: 15px; text-align: center;">
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm" style="padding: 6px 12px; background: #e0e7ff; color: #4f46e5; text-decoration: none; border-radius: 6px; font-size: 12px; margin-right: 4px;">Ver</a>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm" style="padding: 6px 12px; background: #fef3c7; color: #92400e; text-decoration: none; border-radius: 6px; font-size: 12px; margin-right: 4px;">Editar</a>
                        @if ($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="padding: 6px 12px; background: #fee2e2; color: #991b1b; border: none; border-radius: 6px; font-size: 12px; cursor: pointer;" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">Eliminar</button>
                            </form>
                        @else
                            <button class="btn btn-sm" style="padding: 6px 12px; background: #f3f4f6; color: #9ca3af; border: none; border-radius: 6px; font-size: 12px; cursor: default;">Eliminar</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px; display: flex; justify-content: center;">
        {{ $users->links() }}
    </div>
@else
    <div style="background: white; padding: 60px 20px; border-radius: 12px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <p style="color: #6b7280; font-size: 16px;">No hay usuarios registrados.</p>
    </div>
@endif
@endsection
