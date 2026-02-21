@extends('layouts.app')

@section('content')
<div class="header">
    <h1 class="title">{{ $supplier->business_name }}</h1>
    <div class="page-actions">
        <a href="{{ route('admin.proveedores.edit', $supplier) }}" class="btn btn-primary">Editar</a>
        <a href="{{ route('admin.proveedores.index') }}" class="btn btn-outline">Volver</a>
    </div>
</div>

<div class="details-grid">
    <div class="details-card">
        <h3 class="details-title">Información General</h3>
        <p class="detail-item">
            <strong class="detail-label">Código:</strong><br>
            {{ $supplier->code }}
        </p>
        <p class="detail-item">
            <strong class="detail-label">Razon Social:</strong><br>
            {{ $supplier->business_name }}
        </p>
        @if($supplier->trade_name)
        <p class="detail-item">
            <strong class="detail-label">Nombre Comercial:</strong><br>
            {{ $supplier->trade_name }}
        </p>
        @endif
        <p class="detail-item">
            <strong class="detail-label">Contacto:</strong><br>
            {{ $supplier->contact_name ?? '-' }}
        </p>
        <p class="detail-item">
            <strong class="detail-label">Email:</strong><br>
            {{ $supplier->email ?? '-' }}
        </p>
        <p>
            <strong class="detail-label">Teléfono:</strong><br>
            {{ $supplier->phone ?? '-' }}
        </p>
    </div>

    <div class="details-card">
        <h3 class="details-title">Información de Contacto</h3>
        <p class="detail-item">
            <strong class="detail-label">Dirección:</strong><br>
            {{ $supplier->address ?? '-' }}
        </p>
        <p class="detail-item">
            <strong class="detail-label">Ciudad:</strong><br>
            {{ $supplier->city ?? '-' }}
        </p>
        <p class="detail-item">
            <strong class="detail-label">Condiciones de Pago:</strong><br>
            {{ $supplier->payment_terms ?? '-' }}
        </p>
        <p>
            <strong class="detail-label">Estado:</strong><br>
            <span class="status-pill {{ $supplier->status === 'ACT' ? 'status-pill--success' : 'status-pill--danger' }}">
                {{ ucfirst($supplier->status) }}
            </span>
        </p>
    </div>

    <div class="details-card">
        <h3 class="details-title">Información Fiscal</h3>
        <p class="detail-item">
            <strong class="detail-label">RUC/NIT:</strong><br>
            {{ $supplier->tax_id ?? '-' }}
        </p>
        <p>
            <strong class="detail-label">Notas:</strong><br>
            {{ $supplier->notes ?? '-' }}
        </p>
    </div>

    <div class="details-card">
        <h3 class="details-title">Estadísticas</h3>
        <p class="detail-item">
            <strong class="details-stat-value">{{ $supplier->purchaseOrders->count() }}</strong><br>
            <span class="details-stat-text">Órdenes de Compra</span>
        </p>
        <p>
            <strong class="details-stat-value">{{ $supplier->products->count() }}</strong><br>
            <span class="details-stat-text">Productos Asociados</span>
        </p>
    </div>
</div>

@if ($supplier->purchaseOrders->count() > 0)
    <div class="details-card section-card">
        <h3 class="details-title">Últimas Órdenes de Compra</h3>
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
                @foreach ($supplier->purchaseOrders->take(5) as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        <td>{{ number_format($order->total, 2) }}</td>
                        <td>
                            <span class="status-pill
                                @if($order->status === 'received') status-pill--success
                                @elseif($order->status === 'pending' || $order->status === 'draft') status-pill--warning
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


