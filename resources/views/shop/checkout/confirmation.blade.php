@extends('layouts.shop')

@section('content')
    <div style="max-width: 700px; margin: 0 auto;">
        <!-- Success Header -->
        <div style="text-align: center; margin-bottom: 40px;">
            <div style="width: 80px; height: 80px; background: #dcfce7; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                <svg fill="none" stroke="#10b981" viewBox="0 0 24 24" style="width: 40px; height: 40px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 10px;">¡Pedido Confirmado!</h1>
            <p style="color: #6b7280; font-size: 16px;">Gracias por tu compra. Hemos enviado los detalles a tu correo.</p>
        </div>

        <!-- Order Details -->
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #e5e7eb;">
                    <div>
                        <p style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">Numero de pedido</p>
                        <p style="font-size: 18px; font-weight: 700; color: #667eea;">{{ $order->order_number }}</p>
                    </div>
                    <div style="text-align: right;">
                        <p style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">Fecha</p>
                        <p style="font-weight: 500;">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <p style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">Estado</p>
                        <span class="badge badge-success">{{ $order->status_label }}</span>
                    </div>
                    <div>
                        <p style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">Metodo de pago</p>
                        <p style="font-weight: 500;">Tarjeta Online</p>
                    </div>
                </div>

                <div style="background: #f9fafb; border-radius: 8px; padding: 15px;">
                    <p style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">Dirección de envío</p>
                    <p style="font-weight: 500;">{{ $order->shipping_address }}</p>
                    <p style="color: #6b7280;">{{ $order->shipping_city }} {{ $order->shipping_postal_code }}</p>
                    @if($order->shipping_notes)
                        <p style="font-size: 13px; color: #6b7280; margin-top: 8px;">
                            <strong>Notas:</strong> {{ $order->shipping_notes }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header">Productos</div>
            <div class="card-body" style="padding: 0;">
                <table class="table table-striped align-middle" style="width: 100%;">
                    @foreach($order->items as $item)
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 15px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 50px; height: 50px; background: #f3f4f6; border-radius: 6px;"></div>
                                    <div>
                                        <p style="font-weight: 500;">{{ $item->product_name }}</p>
                                        <p style="font-size: 13px; color: #6b7280;">x{{ (int)$item->quantity }}</p>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 15px; text-align: right; font-weight: 500;">
                                ${{ number_format($item->total, 2, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <!-- Order Totals -->
        <div class="card" style="margin-bottom: 30px;">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span style="color: #6b7280;">Subtotal</span>
                    <span>${{ number_format($order->subtotal, 2, ',', '.') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span style="color: #6b7280;">IVA ({{ $order->tax_rate }}%)</span>
                    <span>${{ number_format($order->tax_total, 2, ',', '.') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                    <span style="color: #6b7280;">Envio</span>
                    <span style="color: #10b981;">Gratis</span>
                </div>
                <hr style="margin: 15px 0; border: none; border-top: 2px solid #e5e7eb;">
                <div style="display: flex; justify-content: space-between; font-size: 20px; font-weight: 700;">
                    <span>Total pagado</span>
                    <span style="color: #667eea;">${{ number_format($order->total, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div style="display: flex; gap: 15px; justify-content: center;">
            <a href="{{ route('shop.account.orders') }}" class="btn btn-primary">
                Ver mis pedidos
            </a>
            <a href="{{ route('shop.home') }}" class="btn btn-secondary">
                Seguir comprando
            </a>
        </div>
    </div>
@endsection
