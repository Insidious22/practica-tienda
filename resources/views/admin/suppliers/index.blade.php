@extends('layouts.app')

@section('content')
<div class="header">
    <h1 class="title">Proveedores</h1>
    <a href="{{ route('admin.proveedores.create') }}" class="btn btn-primary" style="padding: 10px 20px; text-decoration: none;">
        + Nuevo Proveedor
    </a>
</div>

@if (session('success'))
    <div class="alert success" style="margin-bottom: 20px;">
        <span>✓</span>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if ($suppliers->count() > 0)
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                <th style="padding: 15px; text-align: left; font-weight: 600; color: #1f2937;">Código</th>
                <th style="padding: 15px; text-align: left; font-weight: 600; color: #1f2937;">Nombre</th>
                <th style="padding: 15px; text-align: left; font-weight: 600; color: #1f2937;">Contacto</th>
                <th style="padding: 15px; text-align: left; font-weight: 600; color: #1f2937;">Teléfono</th>
                <th style="padding: 15px; text-align: left; font-weight: 600; color: #1f2937;">Estado</th>
                <th style="padding: 15px; text-align: center; font-weight: 600; color: #1f2937;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($suppliers as $supplier)
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <td style="padding: 15px; color: #1f2937; font-weight: 500;">{{ $supplier->code }}</td>
                    <td style="padding: 15px; color: #1f2937;">{{ $supplier->business_name }}</td>
                    <td style="padding: 15px; color: #6b7280;">{{ $supplier->contact_name ?? '-' }}</td>
                    <td style="padding: 15px; color: #6b7280;">{{ $supplier->phone ?? '-' }}</td>
                    <td style="padding: 15px;">
                        <span style="background: {{ $supplier->status === 'active' ? '#d1fae5' : '#fee2e2' }}; color: {{ $supplier->status === 'active' ? '#065f46' : '#991b1b' }}; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                            {{ ucfirst($supplier->status) }}
                        </span>
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <a href="{{ route('admin.proveedores.show', $supplier) }}" class="btn btn-sm" style="padding: 6px 12px; background: #e0e7ff; color: #4f46e5; text-decoration: none; border-radius: 6px; font-size: 12px; margin-right: 4px;">Ver</a>
                        <a href="{{ route('admin.proveedores.edit', $supplier) }}" class="btn btn-sm" style="padding: 6px 12px; background: #fef3c7; color: #92400e; text-decoration: none; border-radius: 6px; font-size: 12px; margin-right: 4px;">Editar</a>
                        <form action="{{ route('admin.proveedores.destroy', $supplier) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm" style="padding: 6px 12px; background: #fee2e2; color: #991b1b; border: none; border-radius: 6px; font-size: 12px; cursor: pointer;" onclick="return confirm('¿Seguro que deseas eliminar este proveedor?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px; display: flex; justify-content: center;">
        {{ $suppliers->links() }}
    </div>
@else
    <div style="background: white; padding: 60px 20px; border-radius: 12px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <p style="color: #6b7280; font-size: 16px;">No hay proveedores registrados.</p>
    </div>
@endif
@endsection
