@extends('layouts.app')

@push('styles')
    @safeVite(['resources/css/admin/users.css'])
@endpush

@section('content')
<div class="header">
    <h1 class="title">{{ $user->name }}</h1>
    <div class="page-actions">
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">Editar</a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Volver</a>
    </div>
</div>

<div class="details-grid">
    <div class="details-card">
        <h3 class="details-title">Información Personal</h3>
        <p class="detail-item">
            <strong class="detail-label">Nombre:</strong><br>
            {{ $user->name }}
        </p>
        <p class="detail-item">
            <strong class="detail-label">Email:</strong><br>
            {{ $user->email }}
        </p>
        <p class="detail-item">
            <strong class="detail-label">Teléfono:</strong><br>
            {{ $user->phone ?? '-' }}
        </p>
        <p>
            <strong class="detail-label">Miembro desde:</strong><br>
            {{ $user->created_at->format('d/m/Y H:i') }}
        </p>
    </div>

    <div class="details-card">
        <h3 class="details-title">Roles</h3>
        @if ($user->roles->count() > 0)
            @foreach ($user->roles as $role)
                <div class="role-pill role-pill--large">
                    {{ $role->name }}
                </div>
            @endforeach
        @else
            <p class="role-pill-empty">Sin roles asignados</p>
        @endif
    </div>

    <div class="details-card">
        <h3 class="details-title">Órdenes de Venta</h3>
        <p class="details-stat-value">{{ $user->salesOrders->count() }}</p>
        @if ($user->salesOrders->count() > 0)
            <p class="details-stat-text">
                Monto total: <strong>${{ number_format($user->salesOrders->sum('total'), 2) }}</strong>
            </p>
        @endif
    </div>

    <div class="details-card">
        <h3 class="details-title">Órdenes de Compra</h3>
        <p class="details-stat-value details-stat-value--success">{{ $user->purchaseOrders->count() }}</p>
        @if ($user->purchaseOrders->count() > 0)
            <p class="details-stat-text">
                Monto total: <strong>${{ number_format($user->purchaseOrders->sum('total'), 2) }}</strong>
            </p>
        @endif
    </div>
</div>

@if ($user->salesOrders->count() > 0)
    <div class="details-card section-card">
        <h3 class="details-title">Últimas Órdenes de Venta</h3>
        <table class="admin-table admin-table--compact">
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user->salesOrders->take(5) as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        <td>{{ number_format($order->total, 2) }}</td>
                        <td>
                            <span class="status-pill
                                @if($order->status === 'completed') status-pill--success
                                @elseif($order->status === 'pending') status-pill--warning
                                @elseif($order->status === 'cancelled') status-pill--danger
                                @else status-pill--neutral
                                @endif">
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
