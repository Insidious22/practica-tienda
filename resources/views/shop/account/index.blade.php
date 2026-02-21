@extends('layouts.shop')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('shop.home') }}">Inicio</a>
        <span class="breadcrumb-separator">/</span>
        <span>Mi Cuenta</span>
    </div>

    <h1 class="account-title">Mi Cuenta</h1>

    <div class="account-layout">
        <!-- Sidebar -->
        @include('shop.account._sidebar')

        <!-- Content -->
        <div>
            <!-- Welcome -->
            <div class="card account-hero">
                <div class="card-body">
                    <h2 class="account-hero-title">Hola, {{ $user->name }}</h2>
                    <p class="account-hero-text">Desde tu cuenta puedes ver tus pedidos, gestionar tu informacion y mas.</p>
                </div>
            </div>

            <!-- Stats -->
            <div class="account-stats">
                <div class="card">
                    <div class="card-body account-stat-body">
                        <p class="account-stat-value account-stat-value--primary">{{ $totalOrders }}</p>
                        <p class="account-stat-label">Pedidos realizados</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body account-stat-body">
                        <p class="account-stat-value account-stat-value--success">${{ number_format($totalSpent, 2, ',', '.') }}</p>
                        <p class="account-stat-label">Total gastado</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body account-stat-body">
                        <p class="account-stat-value account-stat-value--warning">{{ $user->created_at->diffForHumans(null, true) }}</p>
                        <p class="account-stat-label">Cliente desde</p>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card">
                <div class="card-header account-recent-header">
                    <span>Pedidos Recientes</span>
                    <a href="{{ route('shop.account.orders') }}" class="account-recent-link">Ver todos</a>
                </div>
                <div class="card-body account-card-body--flush">
                    @if($recentOrders->count() > 0)
                        <table class="table table-striped align-middle account-table">
                            <thead>
                                <tr class="account-table-header-row">
                                    <th class="account-table-header-cell">Pedido</th>
                                    <th class="account-table-header-cell">Fecha</th>
                                    <th class="account-table-header-cell">Estado</th>
                                    <th class="account-table-header-cell account-table-header-cell--right">Total</th>
                                    <th class="account-table-header-cell"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                    <tr class="account-table-row">
                                        <td class="account-table-cell account-table-cell--medium">{{ $order->order_number }}</td>
                                        <td class="account-table-cell account-table-cell--muted">{{ $order->created_at->format('d/m/Y') }}</td>
                                        <td class="account-table-cell">
                                            <span class="badge badge-{{ $order->online_status === 'paid' || $order->online_status === 'delivered' ? 'success' : ($order->online_status === 'cancelled' ? 'danger' : 'warning') }}">
                                                {{ $order->status_label }}
                                            </span>
                                        </td>
                                        <td class="account-table-cell account-table-cell--right account-table-cell--bold">${{ number_format($order->total, 2, ',', '.') }}</td>
                                        <td class="account-table-cell">
                                            <a href="{{ route('shop.account.orders.show', $order) }}" class="account-recent-link">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="account-empty">
                            <p class="account-empty-text">No tienes pedidos aun</p>
                            <a href="{{ route('shop.catalog') }}" class="btn btn-primary">Explorar productos</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
