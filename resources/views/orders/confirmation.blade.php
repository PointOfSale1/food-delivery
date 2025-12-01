@extends('layouts.app')

@section('title', 'Order Confirmed')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Success Message -->
            <div class="text-center mb-5">
                <div class="mb-4">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                </div>
                <h2 class="fw-bold mb-2">Order Placed Successfully!</h2>
                <p class="text-muted">Thank you for your order. We'll prepare it right away.</p>
            </div>
            
            <!-- Order Details Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">Order Details</h5>
                        <span class="badge bg-warning text-dark">{{ ucfirst($order->status) }}</span>
                    </div>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <small class="text-muted">Order Number</small>
                            <h6 class="fw-bold">{{ $order->order_number }}</h6>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Date</small>
                            <h6 class="fw-bold">{{ $order->created_at->format('M d, Y - h:i A') }}</h6>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Restaurant</small>
                            <h6 class="fw-bold">{{ $order->restaurant->name }}</h6>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Payment Method</small>
                            <h6 class="fw-bold">Cash on Delivery</h6>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <!-- Delivery Information -->
                    <h6 class="fw-bold mb-3">Delivery Information</h6>
                    <div class="row g-2 mb-4">
                        <div class="col-12">
                            <strong>{{ $order->customer_name }}</strong>
                        </div>
                        <div class="col-12">
                            <i class="bi bi-telephone"></i> {{ $order->customer_phone }}
                        </div>
                        @if($order->customer_email)
                            <div class="col-12">
                                <i class="bi bi-envelope"></i> {{ $order->customer_email }}
                            </div>
                        @endif
                        <div class="col-12">
                            <i class="bi bi-geo-alt"></i> {{ $order->delivery_address }}, {{ $order->city }}
                        </div>
                        @if($order->notes)
                            <div class="col-12">
                                <i class="bi bi-chat-left-text"></i> <em>{{ $order->notes }}</em>
                            </div>
                        @endif
                    </div>
                    
                    <hr>
                    
                    <!-- Order Items -->
                    <h6 class="fw-bold mb-3">Order Items</h6>
                    <div class="table-responsive mb-3">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->meal_name }}</td>
                                        <td>${{ number_format($item->meal_price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end">${{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end">Subtotal:</td>
                                    <td class="text-end">${{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">Delivery Fee:</td>
                                    <td class="text-end">${{ number_format($order->delivery_fee, 2) }}</td>
                                </tr>
                                <tr class="table-light">
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                    <td class="text-end">
                                        <strong class="text-primary">${{ number_format($order->total, 2) }}</strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle"></i> 
                        <strong>Estimated Delivery Time:</strong> 30-45 minutes
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="text-center">
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="bi bi-house"></i> Back to Home
                </a>
                @auth
                    <a href="{{ route('orders.my-orders') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-bag"></i> View All Orders
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection