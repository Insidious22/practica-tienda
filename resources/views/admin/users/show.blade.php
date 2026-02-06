@extends('layouts.app')

@section('content')
<div class="header">
    <h1 class="title">{{ $user->name }}</h1>
    <div style="display: flex; gap: 12px;">
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary" style="padding: 10px 20px; text-decoration: none;">Editar</a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline" style="padding: 10px 20px; text-decoration: none;">Volver</a>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
    <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <h3 style="margin-bottom: 20px; color: #1f2937;">Información Personal</h3>
        <p style="margin-bottom: 15px;">
            <strong style="color: #1f2937;">Nombre:</strong><br>
            {{ $user->name }}
        </p>
        <p style="margin-bottom: 15px;">
            <strong style="color: #1f2937;">Email:</strong><br>
            {{ $user->email }}
        </p>
        <p style="margin-bottom: 15px;">
            <strong style="color: #1f2937;">Teléfono:</strong><br>
            {{ $user->phone ?? '-' }}
        </p>
        <p>
            <strong style="color: #1f2937;">Miembro desde:</strong><br>
            {{ $user->created_at->format('d/m/Y H:i') }}
        </p>
    </div>

    <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <h3 style="margin-bottom: 20px; color: #1f2937;">Roles</h3>
        @if ($user->roles->count() > 0)
            @foreach ($user->roles as $role)
                <div style="display: inline-block; background: #e0e7ff; color: #4f46e5; padding: 8px 12px; border-radius: 6px; margin-right: 8px; margin-bottom: 8px;">
                    {{ $role->name }}
                </div>
            @endforeach
        @else
            <p style="color: #9ca3af;">Sin roles asignados</p>
        @endif
    </div>

    <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <h3 style="margin-bottom: 20px; color: #1f2937;">Órdenes de Venta</h3>
        <p style="font-size: 32px; font-weight: 700; color: #667eea;">{{ $user->salesOrders->count() }}</p>
        @if ($user->salesOrders->count() > 0)
            <p style="color: #6b7280; font-size: 14px;">
                Monto total: <strong>${{ number_format($user->salesOrders->sum('total'), 2) }}</strong>
            </p>
        @endif
    </div>

    <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <h3 style="margin-bottom: 20px; color: #1f2937;">Órdenes de Compra</h3>
        <p style="font-size: 32px; font-weight: 700; color: #10b981;">{{ $user->purchaseOrders->count() }}</p>
        @if ($user->purchaseOrders->count() > 0)
            <p style="color: #6b7280; font-size: 14px;">
                Monto total: <strong>${{ number_format($user->purchaseOrders->sum('total'), 2) }}</strong>
            </p>
        @endif
    </div>
</div>

@if ($user->salesOrders->count() > 0)
    <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); margin-top: 20px;">
        <h3 style="margin-bottom: 20px; color: #1f2937;">Últimas Órdenes de Venta</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                    <th style="padding: 12px; text-align: left; font-weight: 600;">Número</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600;">Fecha</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600;">Total</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600;">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user->salesOrders->take(5) as $order)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 12px;">{{ $order->order_number }}</td>
                        <td style="padding: 12px;">{{ $order->created_at->format('d/m/Y') }}</td>
                        <td style="padding: 12px;">{{ number_format($order->total, 2) }}</td>
                        <td style="padding: 12px;">
                            <span style="background: 
                                @if($order->status === 'completed') #d1fae5
                                @elseif($order->status === 'pending') #fef3c7
                                @elseif($order->status === 'cancelled') #fee2e2
                                @else #e5e7eb
                                @endif;
                                color: 
                                @if($order->status === 'completed') #065f46
                                @elseif($order->status === 'pending') #92400e
                                @elseif($order->status === 'cancelled') #991b1b
                                @else #374151
                                @endif;
                                padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
