@extends('layouts.app')

@section('content')
<div class="header">
    <h1 class="title">{{ $supplier->name }}</h1>
    <div style="display: flex; gap: 12px;">
        <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="btn btn-primary" style="padding: 10px 20px; text-decoration: none;">Editar</a>
        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline" style="padding: 10px 20px; text-decoration: none;">Volver</a>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
    <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <h3 style="margin-bottom: 20px; color: #1f2937;">Información General</h3>
        <p style="margin-bottom: 15px;">
            <strong style="color: #1f2937;">Código:</strong><br>
            {{ $supplier->code }}
        </p>
        <p style="margin-bottom: 15px;">
            <strong style="color: #1f2937;">Nombre:</strong><br>
            {{ $supplier->name }}
        </p>
        <p style="margin-bottom: 15px;">
            <strong style="color: #1f2937;">Contacto:</strong><br>
            {{ $supplier->contact_person ?? '-' }}
        </p>
        <p style="margin-bottom: 15px;">
            <strong style="color: #1f2937;">Email:</strong><br>
            {{ $supplier->email ?? '-' }}
        </p>
        <p>
            <strong style="color: #1f2937;">Teléfono:</strong><br>
            {{ $supplier->phone ?? '-' }}
        </p>
    </div>

    <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <h3 style="margin-bottom: 20px; color: #1f2937;">Información de Contacto</h3>
        <p style="margin-bottom: 15px;">
            <strong style="color: #1f2937;">Dirección:</strong><br>
            {{ $supplier->address ?? '-' }}
        </p>
        <p style="margin-bottom: 15px;">
            <strong style="color: #1f2937;">Ciudad:</strong><br>
            {{ $supplier->city ?? '-' }}
        </p>
        <p style="margin-bottom: 15px;">
            <strong style="color: #1f2937;">Código Postal:</strong><br>
            {{ $supplier->postal_code ?? '-' }}
        </p>
        <p>
            <strong style="color: #1f2937;">Estado:</strong><br>
            <span style="background: {{ $supplier->status === 'active' ? '#d1fae5' : '#fee2e2' }}; color: {{ $supplier->status === 'active' ? '#065f46' : '#991b1b' }}; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                {{ ucfirst($supplier->status) }}
            </span>
        </p>
    </div>

    <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <h3 style="margin-bottom: 20px; color: #1f2937;">Información Fiscal</h3>
        <p style="margin-bottom: 15px;">
            <strong style="color: #1f2937;">RUC/NIT:</strong><br>
            {{ $supplier->tax_id ?? '-' }}
        </p>
        <p>
            <strong style="color: #1f2937;">Cuenta Bancaria:</strong><br>
            {{ $supplier->bank_account ?? '-' }}
        </p>
    </div>

    <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <h3 style="margin-bottom: 20px; color: #1f2937;">Estadísticas</h3>
        <p style="margin-bottom: 15px;">
            <strong style="color: #1f2937; font-size: 18px;">{{ $supplier->purchaseOrders->count() }}</strong><br>
            <span style="color: #6b7280; font-size: 12px;">Órdenes de Compra</span>
        </p>
        <p>
            <strong style="color: #1f2937; font-size: 18px;">{{ $supplier->products->count() }}</strong><br>
            <span style="color: #6b7280; font-size: 12px;">Productos Asociados</span>
        </p>
    </div>
</div>

@if ($supplier->purchaseOrders->count() > 0)
    <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); margin-top: 20px;">
        <h3 style="margin-bottom: 20px; color: #1f2937;">Últimas Órdenes de Compra</h3>
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
                @foreach ($supplier->purchaseOrders->take(5) as $order)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 12px;">{{ $order->order_number }}</td>
                        <td style="padding: 12px;">{{ $order->created_at->format('d/m/Y') }}</td>
                        <td style="padding: 12px;">{{ number_format($order->total, 2) }}</td>
                        <td style="padding: 12px;">
                            <span style="background: 
                                @if($order->status === 'received') #d1fae5
                                @elseif($order->status === 'pending' || $order->status === 'draft') #fef3c7
                                @elseif($order->status === 'cancelled') #fee2e2
                                @else #e5e7eb
                                @endif;
                                color: 
                                @if($order->status === 'received') #065f46
                                @elseif($order->status === 'pending' || $order->status === 'draft') #92400e
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
