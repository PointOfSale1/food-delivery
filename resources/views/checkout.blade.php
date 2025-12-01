@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">
        <i class="bi bi-credit-card"></i> Checkout
    </h2>
    
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        
        <div class="row">
            <!-- Customer Information -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Delivery Information</h5>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="customer_name" 
                                       class="form-control @error('customer_name') is-invalid @enderror" 
                                       value="{{ old('customer_name', auth()->user()->name ?? '') }}" 
                                       required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Phone Number *</label>
                                <input type="tel" name="customer_phone" 
                                       class="form-control @error('customer_phone') is-invalid @enderror" 
                                       value="{{ old('customer_phone', auth()->user()->phone ?? '') }}" 
                                       required>
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label">Email (Optional)</label>
                                <input type="email" name="customer_email" 
                                       class="form-control @error('customer_email') is-invalid @enderror" 
                                       value="{{ old('customer_email', auth()->user()->email ?? '') }}">
                                @error('customer_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label">Delivery Address *</label>
                                <textarea name="delivery_address" rows="3" 
                                          class="form-control @error('delivery_address') is-invalid @enderror" 
                                          required>{{ old('delivery_address', auth()->user()->address ?? '') }}</textarea>
                                @error('delivery_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">City *</label>
                                <input type="text" name="city" 
                                       class="form-control @error('city') is-invalid @enderror" 
                                       value="{{ old('city', auth()->user()->city ?? '') }}" 
                                       required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label">Special Instructions (Optional)</label>
                                <textarea name="notes" rows="2" 
                                          class="form-control @error('notes') is-invalid @enderror" 
                                          placeholder="e.g., Ring doorbell, call on arrival...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Method -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Payment Method</h5>
                        
                        <div class="alert alert-info">
                            <i class="bi bi-cash-coin"></i> 
                            <strong>Cash on Delivery</strong><br>
                            <small>You will pay when your order is delivered</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Order Summary</h5>
                        
                        <!-- Order Items -->
                        <div class="mb-3">
                            @foreach($items as $item)
                                <div class="d-flex justify-content-between mb-2">
                                    <div>
                                        <small>{{ $item['meal']->name }}</small><br>
                                        <small class="text-muted">Qty: {{ $item['quantity'] }}</small>
                                    </div>
                                    <small>${{ number_format($item['subtotal'], 2) }}</small>
                                </div>
                            @endforeach
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>${{ number_format($subtotal, 2) }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Delivery Fee</span>
                            <span>${{ number_format($deliveryFee, 2) }}</span>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Total</strong>
                            <strong class="text-primary h5 mb-0">
                                ${{ number_format($total, 2) }}
                            </strong>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="bi bi-check-circle"></i> Place Order
                        </button>
                        
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-arrow-left"></i> Back to Cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection