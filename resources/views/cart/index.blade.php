@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">
        <i class="bi bi-cart3"></i> Shopping Cart
    </h2>
    
    @if(!empty($items) && count($items) > 0)
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Item</th>
                                        <th>Price</th>
                                        <th width="150">Quantity</th>
                                        <th>Subtotal</th>
                                        <th width="80"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($item['meal']->image)
                                                        <img src="{{ Storage::url($item['meal']->image) }}" 
                                                             class="rounded me-3" 
                                                             width="60" height="60"
                                                             style="object-fit: cover;"
                                                             alt="{{ $item['meal']->name }}">
                                                    @else
                                                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                                             style="width: 60px; height: 60px;">
                                                            <i class="bi bi-egg-fried text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <strong>{{ $item['meal']->name }}</strong><br>
                                                        <small class="text-muted">
                                                            {{ $item['meal']->restaurant->name }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                ${{ number_format($item['meal']->price, 2) }}
                                            </td>
                                            <td class="align-middle">
                                                <form action="{{ route('cart.update', $item['meal']) }}" 
                                                      method="POST" 
                                                      class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" name="quantity" 
                                                               class="form-control" 
                                                               value="{{ $item['quantity'] }}" 
                                                               min="1" max="99">
                                                        <button class="btn btn-outline-secondary" type="submit">
                                                            <i class="bi bi-arrow-repeat"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="align-middle fw-bold">
                                                ${{ number_format($item['subtotal'], 2) }}
                                            </td>
                                            <td class="align-middle text-center">
                                                <form action="{{ route('cart.remove', $item['meal']) }}" 
                                                      method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Remove this item?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Clear Cart Button -->
                <form action="{{ route('cart.clear') }}" method="POST" class="mb-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="btn btn-outline-danger"
                            onclick="return confirm('Clear entire cart?')">
                        <i class="bi bi-trash"></i> Clear Cart
                    </button>
                </form>
            </div>
            
            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4">Order Summary</h5>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Delivery Fee</span>
                            <span>$5.00</span>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Total</strong>
                            <strong class="text-primary">${{ number_format($total + 5, 2) }}</strong>
                        </div>
                        
                        <a href="{{ route('checkout') }}" class="btn btn-primary w-100 mb-2">
                            <i class="bi bi-credit-card"></i> Proceed to Checkout
                        </a>
                        
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-arrow-left"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="text-center py-5">
            <i class="bi bi-cart-x text-muted" style="font-size: 5rem;"></i>
            <h3 class="mt-4">Your cart is empty</h3>
            <p class="text-muted mb-4">Add some delicious meals to get started!</p>
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i class="bi bi-shop"></i> Browse Restaurants
            </a>
        </div>
    @endif
</div>
@endsection