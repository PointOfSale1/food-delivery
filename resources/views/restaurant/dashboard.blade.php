@extends('restaurant.layouts.dashboard')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm h-100" style="border-left-color: #f59e0b !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Pending Orders</p>
                        <h2 class="fw-bold mb-0">{{ $stats['pending_orders'] }}</h2>
                    </div>
                    <div class="bg-warning bg-opacity-10 rounded p-3">
                        <i class="bi bi-clock-history text-warning" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm h-100" style="border-left-color: #3b82f6 !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Today's Orders</p>
                        <h2 class="fw-bold mb-0">{{ $stats['todays_orders'] }}</h2>
                    </div>
                    <div class="bg-primary bg-opacity-10 rounded p-3">
                        <i class="bi bi-bag-check text-primary" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm h-100" style="border-left-color: #10b981 !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Today's Revenue</p>
                        <h2 class="fw-bold mb-0">${{ number_format($stats['todays_revenue'], 2) }}</h2>
                    </div>
                    <div class="bg-success bg-opacity-10 rounded p-3">
                        <i class="bi bi-cash-coin text-success" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm h-100" style="border-left-color: #8b5cf6 !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Meals</p>
                        <h2 class="fw-bold mb-0">{{ $stats['total_meals'] }}</h2>
                    </div>
                    <div class="bg-purple bg-opacity-10 rounded p-3">
                        <i class="bi bi-egg-fried" style="font-size: 2rem; color: #8b5cf6;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-clock-history"></i> Recent Orders
                    </h5>
                    <a href="{{ route('restaurant.orders.index') }}" 
                    class="btn btn-primary"
                    style="background-color: #ff6767; border-color: #ff6767;">
                        View All Orders
                    </a>

                </div>
                
                @if($recentOrders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Time</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                    <tr>
                                        <td>
                                            <strong>{{ $order->order_number }}</strong>
                                        </td>
                                        <td>
                                            <div>{{ $order->customer_name }}</div>
                                            <small class="text-muted">{{ $order->customer_phone }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                {{ $order->orderItems->sum('quantity') }} items
                                            </span>
                                        </td>
                                        <td>
                                            <strong>${{ number_format($order->total, 2) }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge badge-status bg-{{ $order->status_color }}">
                                                {{ $order->status_label }}
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $order->created_at->diffForHumans() }}
                                            </small>
                                        </td>
                                        <td>
                                            <a href="{{ route('restaurant.orders.show', $order) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3">No orders yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection