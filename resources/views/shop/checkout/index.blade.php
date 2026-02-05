@extends('layouts.shop')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('shop.home') }}">Inicio</a>
        <span class="breadcrumb-separator">/</span>
        <a href="{{ route('shop.cart') }}">Carrito</a>
        <span class="breadcrumb-separator">/</span>
        <span>Checkout</span>
    </div>

    <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 30px;">Checkout</h1>

    <!-- Progress Steps -->
    <div style="display: flex; justify-content: center; gap: 20px; margin-bottom: 40px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <div style="width: 32px; height: 32px; background: #667eea; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600;">1</div>
            <span style="font-weight: 600; color: #667eea;">Envio</span>
        </div>
        <div style="width: 60px; height: 2px; background: #e5e7eb; align-self: center;"></div>
        <div style="display: flex; align-items: center; gap: 10px;">
            <div style="width: 32px; height: 32px; background: #e5e7eb; color: #6b7280; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600;">2</div>
            <span style="color: #6b7280;">Pago</span>
        </div>
        <div style="width: 60px; height: 2px; background: #e5e7eb; align-self: center;"></div>
        <div style="display: flex; align-items: center; gap: 10px;">
            <div style="width: 32px; height: 32px; background: #e5e7eb; color: #6b7280; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600;">3</div>
            <span style="color: #6b7280;">Confirmacion</span>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 380px; gap: 30px;">
        <!-- Shipping Form -->
        <div class="card">
            <div class="card-header">Dirección de Envío</div>
            <div class="card-body">
                <form action="{{ route('shop.checkout.shipping') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Dirección (Calle y número)</label>
                        <input type="text" name="shipping_address" class="form-input"
                               value="{{ old('shipping_address', $user->address) }}"
                               placeholder="Av. 9 de Octubre 123, Dpto 4B" required>
                        @error('shipping_address')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label class="form-label">Cantón / Ciudad</label>
                            <input type="text" name="shipping_city" class="form-input"
                                   value="{{ old('shipping_city', $user->city) }}"
                                   placeholder="Guayaquil (Guayas)" required>
                            @error('shipping_city')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Código Postal (6 dígitos)</label>
                            <input type="text" name="shipping_postal_code" class="form-input"
                                   value="{{ old('shipping_postal_code', $user->postal_code) }}"
                                   placeholder="090101" required>
                            @error('shipping_postal_code')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Referencia de entrega (opcional)</label>
                        <textarea name="shipping_notes" class="form-input" rows="3"
                                  placeholder="Casa blanca, junto a la farmacia...">{{ old('shipping_notes') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px;">
                        Continuar al pago
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Order Summary -->
        <div>
            <div class="card" style="position: sticky; top: 100px;">
                <div class="card-header">Resumen del Pedido</div>
                <div class="card-body">
                    <!-- Items -->
                    <div style="max-height: 250px; overflow-y: auto; margin-bottom: 20px;">
                        @foreach($cart->items as $item)
                            <div style="display: flex; gap: 12px; padding: 10px 0; border-bottom: 1px solid #f3f4f6;">
                                <div style="width: 50px; height: 50px; background: #f3f4f6; border-radius: 6px; flex-shrink: 0;"></div>
                                <div style="flex: 1; min-width: 0;">
                                    <p style="font-weight: 500; font-size: 14px; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $item->product->name }}</p>
                                    <p style="font-size: 13px; color: #6b7280;">Cant: {{ (int)$item->quantity }} x ${{ number_format($item->unit_price, 2, ',', '.') }}</p>
                                </div>
                                <div style="font-weight: 600; font-size: 14px;">
                                    ${{ number_format($item->total, 2, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px;">
                        <span style="color: #6b7280;">Subtotal</span>
                        <span>${{ number_format($totals['subtotal'], 2, ',', '.') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px;">
                        <span style="color: #6b7280;">IVA ({{ $totals['tax_rate'] }}%)</span>
                        <span>${{ number_format($totals['tax_total'], 2, ',', '.') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 14px;">
                        <span style="color: #6b7280;">Envio</span>
                        <span style="color: #10b981;">Gratis</span>
                    </div>
                    <hr style="margin: 15px 0; border: none; border-top: 1px solid #e5e7eb;">
                    <div style="display: flex; justify-content: space-between; font-size: 18px; font-weight: 700;">
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
@endsection
