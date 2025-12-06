@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">
        <i class="bi bi-bag-check"></i> My Orders
    </h2>
    
    @if($orders->count() > 0)
        <div class="row g-4">
            @foreach($orders as $order)
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h5 class="fw-bold mb-1">
                                                Order #{{ $order->order_number }}
                                            </h5>
                                            <p class="text-muted mb-0">
                                                <i class="bi bi-shop"></i> {{ $order->restaurant->name }}
                                            </p>
                                        </div>
                                        <span class="badge badge-status bg-{{ $order->status_color }} fs-6">
                                            {{ $order->status_label }}
                                        </span>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <p class="text-muted small mb-1">
                                            <i class="bi bi-calendar"></i> 
                                            {{ $order->created_at->format('M d, Y - h:i A') }}
                                        </p>
                                        <p class="text-muted small mb-1">
                                            <i class="bi bi-geo-alt"></i> 
                                            {{ $order->delivery_address }}, {{ $order->city }}
                                        </p>
                                        <p class="text-muted small mb-0">
                                            <i class="bi bi-bag"></i> 
                                            {{ $order->orderItems->sum('quantity') }} items
                                        </p>
                                    </div>
                                    
                                    <!-- Order Items -->
                                    <div class="border-top pt-3">
                                        @foreach($order->orderItems as $item)
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>
                                                    <strong>{{ $item->quantity }}x</strong> {{ $item->meal_name }}
                                                </span>
                                                <span class="text-muted">
                                                    ${{ number_format($item->subtotal, 2) }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <div class="col-md-4 text-md-end">
                                    <h3 class="text-primary fw-bold mb-3">
                                        ${{ number_format($order->total, 2) }}
                                    </h3>
                                    
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('orders.confirmation', $order) }}" 
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-eye"></i> View Details
                                        </a>
                                        
                                        @if($order->status === 'delivered')
                                            <a href="{{ route('restaurants.show', $order->restaurant) }}" 
                                               class="btn btn-primary btn-sm">
                                                <i class="bi bi-arrow-repeat"></i> Order Again
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <i class="bi bi-bag-x text-muted" style="font-size: 5rem;"></i>
            <h3 class="mt-4">No orders yet</h3>
            <p class="text-muted mb-4">Start exploring restaurants and place your first order!</p>
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i class="bi bi-shop"></i> Browse Restaurants
            </a>
        </div>
    @endif
</div>
@endsection