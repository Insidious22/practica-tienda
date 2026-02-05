@extends('layouts.shop')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('shop.home') }}">Inicio</a>
        <span class="breadcrumb-separator">/</span>
        <a href="{{ route('shop.account.index') }}">Mi Cuenta</a>
        <span class="breadcrumb-separator">/</span>
        <span>Mis Pedidos</span>
    </div>

    <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 30px;">Mis Pedidos</h1>

    <div style="display: grid; grid-template-columns: 250px 1fr; gap: 30px;">
        <!-- Sidebar -->
        @include('shop.account._sidebar')

        <!-- Content -->
        <div>
            @if($orders->count() > 0)
                <div class="card">
                    <div class="card-body" style="padding: 0;">
                        @foreach($orders as $order)
                            <div style="padding: 20px; border-bottom: 1px solid #e5e7eb;">
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px;">
                                    <div>
                                        <p style="font-weight: 600; margin-bottom: 4px;">{{ $order->order_number }}</p>
                                        <p style="font-size: 13px; color: #6b7280;">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <span class="badge badge-{{ $order->online_status === 'paid' || $order->online_status === 'delivered' ? 'success' : ($order->online_status === 'cancelled' ? 'danger' : 'warning') }}">
                                        {{ $order->status_label }}
                                    </span>
                                </div>

                                <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                                    @foreach($order->items->take(3) as $item)
                                        <div style="width: 50px; height: 50px; background: #f3f4f6; border-radius: 6px;" title="{{ $item->product_name }}"></div>
                                    @endforeach
                                    @if($order->items->count() > 3)
                                        <div style="width: 50px; height: 50px; background: #f3f4f6; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #6b7280; font-size: 12px;">
                                            +{{ $order->items->count() - 3 }}
                                        </div>
                                    @endif
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <p style="font-weight: 600; color: #667eea;">${{ number_format($order->total, 2, ',', '.') }}</p>
                                    <a href="{{ route('shop.account.orders.show', $order) }}" class="btn btn-secondary" style="padding: 8px 16px; font-size: 13px;">
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
                    <div class="card-body text-center" style="padding: 60px;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 64px; height: 64px; opacity: 0.3; margin: 0 auto 20px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 10px;">No tienes pedidos</h3>
                        <p style="color: #6b7280; margin-bottom: 20px;">Cuando realices tu primera compra, aparecera aqui.</p>
                        <a href="{{ route('shop.catalog') }}" class="btn btn-primary">Explorar productos</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        @media (max-width: 768px) {
            [style*="grid-template-columns: 250px 1fr"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endsection
