@extends('layouts.shop')

@push('styles')
    @safeVite(['resources/css/shop/account.css'])
@endpush

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('shop.home') }}">Inicio</a>
        <span class="breadcrumb-separator">/</span>
        <a href="{{ route('shop.account.index') }}">Mi Cuenta</a>
        <span class="breadcrumb-separator">/</span>
        <span>Mis Pedidos</span>
    </div>

    <h1 class="account-title">Mis Pedidos</h1>

    <div class="account-layout">
        <!-- Sidebar -->
        @include('shop.account._sidebar')

        <!-- Content -->
        <div>
            @if($orders->count() > 0)
                <div class="card">
                    <div class="card-body account-orders-body">
                        @foreach($orders as $order)
                            <div class="account-order-item">
                                <div class="account-order-head">
                                    <div>
                                        <p class="account-order-id">{{ $order->order_number }}</p>
                                        <p class="account-order-date">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <span class="badge badge-{{ $order->online_status === 'paid' || $order->online_status === 'delivered' ? 'success' : ($order->online_status === 'cancelled' ? 'danger' : 'warning') }}">
                                        {{ $order->status_label }}
                                    </span>
                                </div>

                                <div class="account-order-items">
                                    @foreach($order->items->take(3) as $item)
                                        <div class="account-order-thumb" title="{{ $item->product_name }}"></div>
                                    @endforeach
                                    @if($order->items->count() > 3)
                                        <div class="account-order-thumb account-order-thumb--more">
                                            +{{ $order->items->count() - 3 }}
                                        </div>
                                    @endif
                                </div>

                                <div class="account-order-foot">
                                    <p class="account-order-total">${{ number_format($order->total, 2, ',', '.') }}</p>
                                    <a href="{{ route('shop.account.orders.show', $order) }}" class="btn btn-secondary account-order-button">
                                        Ver detalles
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="pagination">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="card">
                    <div class="card-body text-center account-empty">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="account-empty-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <h3 class="account-empty-title">No tienes pedidos</h3>
                        <p class="account-empty-note">Cuando realices tu primera compra, aparecera aqui.</p>
                        <a href="{{ route('shop.catalog') }}" class="btn btn-primary">Explorar productos</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
