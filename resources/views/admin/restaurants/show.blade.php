@extends('admin.layouts.dashboard')

@section('title', 'Restaurant Details')
@section('page-title', $restaurant->name)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Restaurant Info -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-3">
                        @if($restaurant->logo)
                            <img src="{{ Storage::url($restaurant->logo) }}" 
                                 class="img-fluid rounded" 
                                 alt="{{ $restaurant->name }}">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                 style="height: 150px;">
                                <i class="bi bi-shop text-muted" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-9">
                        <h4 class="fw-bold mb-3">{{ $restaurant->name }}</h4>
                        <p class="mb-2">
                            <i class="bi bi-envelope"></i> {{ $restaurant->email }}
                        </p>
                        @if($restaurant->phone)
                            <p class="mb-2">
                                <i class="bi bi-telephone"></i> {{ $restaurant->phone }}
                            </p>
                        @endif
                        @if($restaurant->address)
                            <p class="mb-2">
                                <i class="bi bi-geo-alt"></i> {{ $restaurant->address }}, {{ $restaurant->city }}
                            </p>
                        @endif
                        <p class="mb-2">
                            <strong>Status:</strong> 
                            <span class="badge bg-{{ $restaurant->status == 'active' ? 'success' : 'danger' }}">
                                {{ ucfirst($restaurant->status) }}
                            </span>
                        </p>
                        @if($restaurant->description)
                            <p class="text-muted mb-0">{{ $restaurant->description }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Orders -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-4">Recent Orders</h5>
                
                @if($restaurant->orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($restaurant->orders as $order)
                                    <tr>
                                        <td><strong>{{ $order->order_number }}</strong></td>
                                        <td>{{ $order->customer_name }}</td>
                                        <td>${{ number_format($order->total, 2) }}</td>
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
                @else
                    <p class="text-muted text-center py-4">No orders yet</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Statistics -->
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <h6 class="fw-bold mb-4">Statistics</h6>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Total Orders</span>
                        <strong>{{ $stats['total_orders'] }}</strong>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Total Revenue</span>
                        <strong class="text-success">${{ number_format($stats['total_revenue'], 2) }}</strong>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Total Meals</span>
                        <strong>{{ $stats['total_meals'] }}</strong>
                    </div>
                </div>
                
                <div class="mb-0">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Categories</span>
                        <strong>{{ $stats['total_categories'] }}</strong>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Account Info -->
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Account Information</h6>
                <p class="small mb-2">
                    <strong>Created:</strong> {{ $restaurant->created_at->format('M d, Y') }}
                </p>
                <p class="small mb-0">
                    <strong>Last Updated:</strong> {{ $restaurant->updated_at->format('M d, Y') }}
                </p>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Actions</h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.restaurants.edit', $restaurant) }}" 
                       class="btn btn-primary btn-sm"
                        style="background-color: #ff6767; border-color: #ff6767;">
                        <i class="bi bi-pencil"></i> Edit Restaurant
                    </a>
                    <a href="{{ route('restaurants.show', $restaurant) }}" 
                       class="btn btn-outline-secondary btn-sm" 
                       target="_blank">
                        <i class="bi bi-box-arrow-up-right"></i> View on Website
                    </a>
                    <form action="{{ route('admin.restaurants.destroy', $restaurant) }}" 
                          method="POST"
                          onsubmit="return confirm('Delete this restaurant?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                            <i class="bi bi-trash"></i> Delete Restaurant
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection