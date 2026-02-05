@extends('layouts.shop')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('shop.home') }}">Inicio</a>
        <span class="breadcrumb-separator">/</span>
        <a href="{{ route('shop.account.index') }}">Mi Cuenta</a>
        <span class="breadcrumb-separator">/</span>
        <a href="{{ route('shop.account.orders') }}">Mis Pedidos</a>
        <span class="breadcrumb-separator">/</span>
        <span>{{ $order->order_number }}</span>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="font-size: 28px; font-weight: 700;">Pedido {{ $order->order_number }}</h1>
        <span class="badge badge-{{ $order->online_status === 'paid' || $order->online_status === 'delivered' ? 'success' : ($order->online_status === 'cancelled' ? 'danger' : 'warning') }}" style="font-size: 14px; padding: 8px 16px;">
            {{ $order->status_label }}
        </span>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 350px; gap: 30px;">
        <!-- Order Details -->
        <div>
            <!-- Items -->
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-header">Productos</div>
                <div class="card-body" style="padding: 0;">
                    @foreach($order->items as $item)
                        <div style="display: flex; gap: 15px; padding: 15px; border-bottom: 1px solid #e5e7eb;">
                            <div style="width: 70px; height: 70px; background: #f3f4f6; border-radius: 8px; flex-shrink: 0;"></div>
                            <div style="flex: 1;">
                                <p style="font-weight: 600; margin-bottom: 4px;">{{ $item->product_name }}</p>
                                <p style="font-size: 13px; color: #6b7280;">Cantidad: {{ (int)$item->quantity }} x $ {{ number_format($item->unit_price, 2) }}</p>
                            </div>
                            <div style="font-weight: 600;">
                                $ {{ number_format($item->total, 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="card">
                <div class="card-header">Direccion de Envio</div>
                <div class="card-body">
                    <p style="font-weight: 500; margin-bottom: 5px;">{{ $order->shipping_address }}</p>
                    <p style="color: #6b7280;">{{ $order->shipping_city }} {{ $order->shipping_postal_code }}</p>
                    @if($order->shipping_notes)
                        <p style="font-size: 13px; color: #6b7280; margin-top: 10px;">
                            <strong>Notas:</strong> {{ $order->shipping_notes }}
                        </p>
                    @endif

                    @if($order->tracking_number)
                        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e5e7eb;">
                            <p style="font-size: 13px; color: #6b7280;">Numero de seguimiento:</p>
                            <p style="font-weight: 600; color: #667eea;">{{ $order->tracking_number }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div>
            <div class="card" style="position: sticky; top: 100px;">
                <div class="card-header">Resumen</div>
                <div class="card-body">
                    <div style="margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #e5e7eb;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px;">
                            <span style="color: #6b7280;">Fecha del pedido</span>
                            <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px;">
                            <span style="color: #6b7280;">Metodo de pago</span>
                            <span>Tarjeta Online</span>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="color: #6b7280;">Subtotal</span>
                        <span>$ {{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="color: #6b7280;">IVA ({{ $order->tax_rate }}%)</span>
                        <span>$ {{ number_format($order->tax_total, 2) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                        <span style="color: #6b7280;">Envio</span>
                        <span style="color: #10b981;">Gratis</span>
                    </div>
                    <hr style="margin: 15px 0; border: none; border-top: 2px solid #e5e7eb;">
                    <div style="display: flex; justify-content: space-between; font-size: 20px; font-weight: 700;">
                        <span>Total</span>
                        <span style="color: #667eea;">$ {{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <a href="{{ route('shop.account.orders') }}" class="btn btn-secondary" style="width: 100%; margin-top: 15px;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver a mis pedidos
            </a>
        </div>
    </div>

    <style>
        @media (max-width: 900px) {
            [style*="grid-template-columns: 1fr 350px"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endsection
