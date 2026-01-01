@extends('admin.layouts.dashboard')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm h-100" style="border-left-color: #3b82f6 !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Restaurants</p>
                        <h2 class="fw-bold mb-0">{{ $stats['total_restaurants'] }}</h2>
                        <small class="text-success">{{ $stats['active_restaurants'] }} active</small>
                    </div>
                    <div class="bg-primary bg-opacity-10 rounded p-3">
                        <i class="bi bi-shop text-primary" style="font-size: 2rem;"></i>
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
                        <p class="text-muted mb-1">Total Users</p>
                        <h2 class="fw-bold mb-0">{{ $stats['total_users'] }}</h2>
                    </div>
                    <div class="bg-success bg-opacity-10 rounded p-3">
                        <i class="bi bi-people text-success" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm h-100" style="border-left-color: #f59e0b !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Orders</p>
                        <h2 class="fw-bold mb-0">{{ $stats['total_orders'] }}</h2>
                        <small class="text-warning">{{ $stats['pending_orders'] }} pending</small>
                    </div>
                    <div class="bg-warning bg-opacity-10 rounded p-3">
                        <i class="bi bi-bag text-warning" style="font-size: 2rem;"></i>
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
                        <p class="text-muted mb-1">Total Revenue</p>
                        <h2 class="fw-bold mb-0">${{ number_format($stats['total_revenue'], 2) }}</h2>
                    </div>
                    <div class="bg-purple bg-opacity-10 rounded p-3">
                        <i class="bi bi-cash-coin" style="font-size: 2rem; color: #8b5cf6;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Today's Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Today's Performance</h6>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Orders Today</span>
                    <strong>{{ $stats['todays_orders'] }}</strong>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Revenue Today</span>
                    <strong class="text-success">${{ number_format($stats['todays_revenue'], 2) }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Restaurants -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-shop"></i> Recent Restaurants
                    </h5>
                    <a href="{{ route('admin.restaurants.index') }}" class="btn btn-primary"
                        style="background-color: #ff6767; border-color: #ff6767;">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>City</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentRestaurants as $restaurant)
                                <tr>
                                    <td><strong>{{ $restaurant->name }}</strong></td>
                                    <td>{{ $restaurant->email }}</td>
                                    <td>{{ $restaurant->city }}</td>
                                    <td>
                                        <span class="badge bg-{{ $restaurant->status == 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($restaurant->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $restaurant->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.restaurants.edit', $restaurant) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                        <i class="bi bi-bag"></i> Recent Orders
                    </h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-primary"
                        style="background-color: #ff6767; border-color: #ff6767;">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Order #</th>
                                <th>Restaurant</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                                <tr>
                                    <td><strong>{{ $order->order_number }}</strong></td>
                                    <td>{{ $order->restaurant->name }}</td>
                                    <td>{{ $order->customer_name }}</td>
                                    <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $order->status_color }}">
                                            {{ $order->status_label }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection