@extends('layouts.shop')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('shop.home') }}">Inicio</a>
        <span class="breadcrumb-separator">/</span>
        <span>Carrito</span>
    </div>

    <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 30px;">Carrito de Compras</h1>

    @if($cart->items->count() > 0)
        <div style="display: grid; grid-template-columns: 1fr 350px; gap: 30px;">
            <!-- Cart Items -->
            <div class="card">
                <div class="card-body" style="padding: 0;">
                    <table class="table table-striped align-middle" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                                <th style="padding: 15px; text-align: left; font-size: 12px; text-transform: uppercase; color: #6b7280;">Producto</th>
                                <th style="padding: 15px; text-align: center; font-size: 12px; text-transform: uppercase; color: #6b7280;">Precio</th>
                                <th style="padding: 15px; text-align: center; font-size: 12px; text-transform: uppercase; color: #6b7280;">Cantidad</th>
                                <th style="padding: 15px; text-align: right; font-size: 12px; text-transform: uppercase; color: #6b7280;">Subtotal</th>
                                <th style="padding: 15px; width: 50px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart->items as $item)
                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                    <td style="padding: 20px;">
                                        <div style="display: flex; align-items: center; gap: 15px;">
                                            <div style="width: 80px; height: 80px; background: #f3f4f6; border-radius: 8px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                                @if($item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                @else
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 32px; height: 32px; opacity: 0.3;">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div>
                                                <a href="{{ route('shop.product', $item->product->id) }}" style="font-weight: 600; color: #1f2937; text-decoration: none;">
                                                    {{ $item->product->name }}
                                                </a>
                                                @if($item->product->category)
                                                    <p style="font-size: 13px; color: #6b7280; margin-top: 4px;">{{ $item->product->category->name }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 20px; text-align: center;">
                                        $ {{ number_format($item->unit_price, 2) }}
                                    </td>
                                    <td style="padding: 20px; text-align: center;">
                                        <form action="{{ route('shop.cart.update', $item) }}" method="POST" style="display: inline-flex; align-items: center; border: 1px solid #e5e7eb; border-radius: 6px;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" name="quantity" value="{{ max(0, $item->quantity - 1) }}" style="padding: 8px 12px; border: none; background: none; cursor: pointer;">-</button>
                                            <span style="padding: 8px 12px; min-width: 40px; text-align: center;">{{ (int)$item->quantity }}</span>
                                            <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" style="padding: 8px 12px; border: none; background: none; cursor: pointer;">+</button>
                                        </form>
                                    </td>
                                    <td style="padding: 20px; text-align: right; font-weight: 600;">
                                        $ {{ number_format($item->total, 2) }}
                                    </td>
                                    <td style="padding: 20px;">
                                        <form action="{{ route('shop.cart.remove', $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 5px;" title="Eliminar">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Order Summary -->
            <div>
                <div class="card" style="position: sticky; top: 100px;">
                    <div class="card-header">Resumen del Pedido</div>
                    <div class="card-body">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                            <span style="color: #6b7280;">Subtotal ({{ $cart->total_items }} productos)</span>
                            <span>$ {{ number_format($cart->subtotal, 2) }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                            <span style="color: #6b7280;">Envio</span>
                            <span style="color: #10b981;">Gratis</span>
                        </div>
                        <hr style="margin: 20px 0; border: none; border-top: 1px solid #e5e7eb;">
                        <div style="display: flex; justify-content: space-between; font-size: 18px; font-weight: 700;">
                            <span>Total</span>
                            <span style="color: #667eea;">$ {{ number_format($cart->subtotal, 2) }}</span>
                        </div>

                        @auth
                            <a href="{{ route('shop.checkout.index') }}" class="btn btn-primary" style="width: 100%; margin-top: 20px; padding: 14px;">
                                Proceder al Checkout
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('shop.login') }}?redirect=checkout" class="btn btn-primary" style="width: 100%; margin-top: 20px; padding: 14px;">
                                Iniciar sesion para comprar
                            </a>
                            <p style="text-align: center; margin-top: 10px; font-size: 13px; color: #6b7280;">
                                ¿No tienes cuenta? <a href="{{ route('shop.register') }}" style="color: #667eea;">Registrate</a>
                            </p>
                        @endauth

                        <form action="{{ route('shop.cart.clear') }}" method="POST" style="margin-top: 15px;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-secondary" style="width: 100%;" onclick="return confirm('¿Seguro que quieres vaciar el carrito?')">
                                Vaciar carrito
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center" style="padding: 80px 20px;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 80px; height: 80px; opacity: 0.2; margin: 0 auto 20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h2 style="font-size: 20px; font-weight: 600; margin-bottom: 10px;">Tu carrito esta vacio</h2>
                <p style="color: #6b7280; margin-bottom: 25px;">Agrega productos para comenzar tu compra</p>
                <a href="{{ route('shop.catalog') }}" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Explorar productos
                </a>
            </div>
        </div>
    @endif

    <style>
        @media (max-width: 900px) {
            [style*="grid-template-columns: 1fr 350px"] {
                grid-template-columns: 1fr !important;
            }
        }

        @media (max-width: 600px) {
            table {
                display: block;
            }
            thead {
                display: none;
            }
            tbody {
                display: block;
            }
            tr {
                display: block;
                padding: 15px;
            }
            td {
                display: block;
                padding: 5px 0 !important;
                text-align: left !important;
            }
            td:first-child {
                padding-bottom: 15px !important;
            }
        }
    </style>
@endsection
