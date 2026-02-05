@extends('layouts.shop')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('shop.home') }}">Inicio</a>
        <span class="breadcrumb-separator">/</span>
        <a href="{{ route('shop.cart') }}">Carrito</a>
        <span class="breadcrumb-separator">/</span>
        <span>Pago</span>
    </div>

    <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 30px;">Pago</h1>

    <!-- Progress Steps -->
    <div style="display: flex; justify-content: center; gap: 20px; margin-bottom: 40px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <div style="width: 32px; height: 32px; background: #10b981; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <span style="color: #10b981;">Envio</span>
        </div>
        <div style="width: 60px; height: 2px; background: #667eea; align-self: center;"></div>
        <div style="display: flex; align-items: center; gap: 10px;">
            <div style="width: 32px; height: 32px; background: #667eea; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600;">2</div>
            <span style="font-weight: 600; color: #667eea;">Pago</span>
        </div>
        <div style="width: 60px; height: 2px; background: #e5e7eb; align-self: center;"></div>
        <div style="display: flex; align-items: center; gap: 10px;">
            <div style="width: 32px; height: 32px; background: #e5e7eb; color: #6b7280; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600;">3</div>
            <span style="color: #6b7280;">Confirmacion</span>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 380px; gap: 30px;">
        <!-- Payment Form -->
        <div>
            <!-- Shipping Summary -->
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-body" style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="font-weight: 600; margin-bottom: 5px;">Dirección de envío</p>
                        <p style="color: #6b7280; font-size: 14px;">
                            {{ $shippingData['shipping_address'] }}, {{ $shippingData['shipping_city'] }} {{ $shippingData['shipping_postal_code'] }}
                        </p>
                    </div>
                    <a href="{{ route('shop.checkout.index') }}" style="color: #667eea; text-decoration: none; font-size: 14px;">Editar</a>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="card">
                <div class="card-header">Metodo de Pago</div>
                <div class="card-body">
                    <form action="{{ route('shop.checkout.process') }}" method="POST" id="payment-form">
                        @csrf

                        <div style="background: #f0fdf4; border: 1px solid #86efac; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                                <svg fill="none" stroke="#10b981" viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span style="font-weight: 600; color: #166534;">Modo de prueba activo</span>
                            </div>
                            <p style="font-size: 14px; color: #166534;">
                                El sistema de pagos esta en modo de prueba. Tu pedido sera procesado sin cobro real.
                                En produccion, aqui se integrara Stripe para pagos con tarjeta.
                            </p>
                        </div>

                        <!-- Simulated Card Input -->
                        <div class="form-group mb-3">
                            <label class="form-label">Numero de tarjeta</label>
                            <input type="text" class="form-input form-control" value="4242 4242 4242 4242" disabled style="background: #f9fafb;">
                            <small style="color: #6b7280;">Tarjeta de prueba - no se realizara cobro</small>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div class="form-group mb-3">
                                <label class="form-label">Fecha de expiracion</label>
                                <input type="text" class="form-input form-control" value="12/28" disabled style="background: #f9fafb;">
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">CVC</label>
                                <input type="text" class="form-input form-control" value="123" disabled style="background: #f9fafb;">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 16px; font-size: 16px;" id="submit-btn">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Pagar ${{ number_format($totals['total'], 2, ',', '.') }}
                        </button>
                    </form>

                    <p style="text-align: center; margin-top: 15px; font-size: 12px; color: #6b7280;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px; display: inline; vertical-align: middle;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Pago seguro procesado por Stripe
                    </p>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div>
            <div class="card" style="position: sticky; top: 100px;">
                <div class="card-header">Resumen del Pedido</div>
                <div class="card-body">
                    <div style="max-height: 200px; overflow-y: auto; margin-bottom: 20px;">
                        @foreach($cart->items as $item)
                            <div style="display: flex; gap: 12px; padding: 8px 0; border-bottom: 1px solid #f3f4f6;">
                                <div style="flex: 1; min-width: 0;">
                                    <p style="font-weight: 500; font-size: 14px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $item->product->name }}</p>
                                    <p style="font-size: 12px; color: #6b7280;">x{{ (int)$item->quantity }}</p>
                                </div>
                                <div style="font-weight: 500; font-size: 14px;">
                                    ${{ number_format($item->total, 2, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px;">
                        <span style="color: #6b7280;">Subtotal</span>
                        <span>${{ number_format($totals['subtotal'], 2, ',', '.') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px;">
                        <span style="color: #6b7280;">IVA ({{ $totals['tax_rate'] }}%)</span>
                        <span>${{ number_format($totals['tax_total'], 2, ',', '.') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 14px;">
                        <span style="color: #6b7280;">Envio</span>
                        <span style="color: #10b981;">Gratis</span>
                    </div>
                    <hr style="margin: 15px 0; border: none; border-top: 1px solid #e5e7eb;">
                    <div style="display: flex; justify-content: space-between; font-size: 20px; font-weight: 700;">
                        <span>Total</span>
                        <span style="color: #667eea;">${{ number_format($totals['total'], 2, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 900px) {
            [style*="grid-template-columns: 1fr 380px"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>

    <script>
        document.getElementById('payment-form').addEventListener('submit', function(e) {
            const btn = document.getElementById('submit-btn');
            btn.disabled = true;
            btn.innerHTML = '<span style="display: inline-block; width: 20px; height: 20px; border: 2px solid white; border-top-color: transparent; border-radius: 50%; animation: spin 1s linear infinite;"></span> Procesando...';
        });
    </script>

    <style>
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
@endsection
