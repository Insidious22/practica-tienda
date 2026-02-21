<turbo-frame id="{{ $turboFrame ?? 'main-content' }}">
    <div class="breadcrumb">
        <a href="{{ route('shop.home') }}" data-turbo-frame="_top">Inicio</a>
        <span class="breadcrumb-separator">/</span>
        <span>Carrito</span>
    </div>

    <h1 class="cart-title">Carrito de Compras</h1>

    @if($cart->items->count() > 0)
        <div class="cart-layout">
            <div class="card">
                <div class="card-body cart-card-body">
                    <table class="table table-striped align-middle cart-table">
                        <thead>
                            <tr class="cart-header-row">
                                <th class="cart-header-cell">Producto</th>
                                <th class="cart-header-cell cart-header-cell--center">Precio</th>
                                <th class="cart-header-cell cart-header-cell--center">Cantidad</th>
                                <th class="cart-header-cell cart-header-cell--right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart->items as $item)
                                <tr class="cart-row">
                                    <td class="cart-cell">
                                        <a href="{{ route('content.product', $item->product) }}" data-turbo-frame="{{ $turboFrame ?? 'main-content' }}">
                                            {{ $item->product->name }}
                                        </a>
                                    </td>
                                    <td class="cart-cell cart-cell--center">$ {{ number_format($item->unit_price, 2) }}</td>
                                    <td class="cart-cell cart-cell--center">{{ (int) $item->quantity }}</td>
                                    <td class="cart-cell cart-cell--right">$ {{ number_format($item->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                <div class="card cart-summary-card">
                    <div class="card-header">Resumen</div>
                    <div class="card-body">
                        <div class="cart-summary-total">
                            <span>Total</span>
                            <span class="cart-summary-total-value">$ {{ number_format($cart->subtotal, 2) }}</span>
                        </div>
                        <a href="{{ route('shop.checkout.index') }}" data-turbo-frame="_top" class="btn btn-primary cart-checkout-btn">
                            Proceder al Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <x-turbo-alert type="info" :dismissible="false">
            Tu carrito esta vacio.
            <a href="{{ route('content.catalog') }}" data-turbo-frame="{{ $turboFrame ?? 'main-content' }}" class="btn btn-primary btn-sm ms-3">
                Ver productos
            </a>
        </x-turbo-alert>
    @endif
</turbo-frame>
