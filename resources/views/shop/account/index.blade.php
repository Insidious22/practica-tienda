@extends('layouts.shop')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('shop.home') }}">Inicio</a>
        <span class="breadcrumb-separator">/</span>
        <span>Mi Cuenta</span>
    </div>

    <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 30px;">Mi Cuenta</h1>

    <div style="display: grid; grid-template-columns: 250px 1fr; gap: 30px;">
        <!-- Sidebar -->
        @include('shop.account._sidebar')

        <!-- Content -->
        <div>
            <!-- Welcome -->
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-body">
                    <h2 style="font-size: 20px; font-weight: 600; margin-bottom: 10px;">Hola, {{ $user->name }}</h2>
                    <p style="color: #6b7280;">Desde tu cuenta puedes ver tus pedidos, gestionar tu informacion y mas.</p>
                </div>
            </div>

            <!-- Stats -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
                <div class="card">
                    <div class="card-body" style="text-align: center;">
                        <p style="font-size: 32px; font-weight: 700; color: #667eea;">{{ $totalOrders }}</p>
                        <p style="color: #6b7280; font-size: 14px;">Pedidos realizados</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body" style="text-align: center;">
                        <p style="font-size: 32px; font-weight: 700; color: #10b981;">${{ number_format($totalSpent, 2, ',', '.') }}</p>
                        <p style="color: #6b7280; font-size: 14px;">Total gastado</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body" style="text-align: center;">
                        <p style="font-size: 32px; font-weight: 700; color: #f59e0b;">{{ $user->created_at->diffForHumans(null, true) }}</p>
                        <p style="color: #6b7280; font-size: 14px;">Cliente desde</p>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <span>Pedidos Recientes</span>
                    <a href="{{ route('shop.account.orders') }}" style="color: #667eea; text-decoration: none; font-size: 14px;">Ver todos</a>
                </div>
                <div class="card-body" style="padding: 0;">
                    @if($recentOrders->count() > 0)
                        <table class="table table-striped align-middle" style="width: 100%;">
                            <thead>
                                <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                                    <th style="padding: 12px 15px; text-align: left; font-size: 12px; color: #6b7280; text-transform: uppercase;">Pedido</th>
                                    <th style="padding: 12px 15px; text-align: left; font-size: 12px; color: #6b7280; text-transform: uppercase;">Fecha</th>
                                    <th style="padding: 12px 15px; text-align: left; font-size: 12px; color: #6b7280; text-transform: uppercase;">Estado</th>
                                    <th style="padding: 12px 15px; text-align: right; font-size: 12px; color: #6b7280; text-transform: uppercase;">Total</th>
                                    <th style="padding: 12px 15px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                    <tr style="border-bottom: 1px solid #e5e7eb;">
                                        <td style="padding: 15px; font-weight: 500;">{{ $order->order_number }}</td>
                                        <td style="padding: 15px; color: #6b7280;">{{ $order->created_at->format('d/m/Y') }}</td>
                                        <td style="padding: 15px;">
                                            <span class="badge badge-{{ $order->online_status === 'paid' || $order->online_status === 'delivered' ? 'success' : ($order->online_status === 'cancelled' ? 'danger' : 'warning') }}">
                                                {{ $order->status_label }}
                                            </span>
                                        </td>
                                        <td style="padding: 15px; text-align: right; font-weight: 600;">${{ number_format($order->total, 2, ',', '.') }}</td>
                                        <td style="padding: 15px;">
                                            <a href="{{ route('shop.account.orders.show', $order) }}" style="color: #667eea; text-decoration: none; font-size: 14px;">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div style="padding: 40px; text-align: center;">
                            <p style="color: #6b7280; margin-bottom: 15px;">No tienes pedidos aun</p>
                            <a href="{{ route('shop.catalog') }}" class="btn btn-primary">Explorar productos</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 768px) {
            [style*="grid-template-columns: 250px 1fr"] {
                grid-template-columns: 1fr !important;
            }
            [style*="grid-template-columns: repeat(3, 1fr)"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endsection
