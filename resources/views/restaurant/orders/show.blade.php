@extends('restaurant.layouts.dashboard')

@section('title', 'Order Details')
@section('page-title', 'Order Details')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Order Details Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold mb-1">{{ $order->order_number }}</h4>
                        <small class="text-muted">
                            Placed on {{ $order->created_at->format('M d, Y - h:i A') }}
                        </small>
                    </div>
                    <span class="badge badge-status bg-{{ $order->status_color }} fs-6">
                        {{ $order->status_label }}
                    </span>
                </div>
                
                <!-- Customer Information -->
                <h5 class="fw-bold mb-3">Customer Information</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="text-muted small">Name</label>
                        <p class="mb-0"><strong>{{ $order->customer_name }}</strong></p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Phone</label>
                        <p class="mb-0">
                            <strong>
                                <i class="bi bi-telephone"></i> {{ $order->customer_phone }}
                            </strong>
                        </p>
                    </div>
                    @if($order->customer_email)
                        <div class="col-12">
                            <label class="text-muted small">Email</label>
                            <p class="mb-0">
                                <i class="bi bi-envelope"></i> {{ $order->customer_email }}
                            </p>
                        </div>
                    @endif
                    <div class="col-12">
                        <label class="text-muted small">Delivery Address</label>
                        <p class="mb-0">
                            <i class="bi bi-geo-alt"></i> {{ $order->delivery_address }}, {{ $order->city }}
                        </p>
                    </div>
                    @if($order->notes)
                        <div class="col-12">
                            <label class="text-muted small">Special Instructions</label>
                            <p class="mb-0 fst-italic">
                                <i class="bi bi-chat-left-text"></i> {{ $order->notes }}
                            </p>
                        </div>
                    @endif
                </div>
                
                <hr>
                
                <!-- Order Items -->
                <h5 class="fw-bold mb-3">Order Items</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->meal_name }}</strong>
                                        @if($item->special_instructions)
                                            <br><small class="text-muted fst-italic">{{ $item->special_instructions }}</small>
                                        @endif
                                    </td>
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
                                    <strong class="text-primary fs-5">${{ number_format($order->total, 2) }}</strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        
        <a href="{{ route('restaurant.orders.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Orders
        </a>
    </div>
    
    <!-- Status Update Card -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Update Status</h5>
                
                <form action="{{ route('restaurant.orders.updateStatus', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-3">
                        <label class="form-label">Current Status</label>
                        <select name="status" class="form-select form-select-lg">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>
                                Confirmed
                            </option>
                            <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>
                                Preparing
                            </option>
                            <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>
                                Ready for Delivery
                            </option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                Delivered
                            </option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                Cancelled
                            </option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-circle"></i> Update Status
                    </button>
                </form>
                
                <hr class="my-4">
                
                <!-- Order Timeline -->
                <h6 class="fw-bold mb-3">Order Timeline</h6>
                <div class="timeline">
                    <div class="mb-3">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <strong>Order Placed</strong><br>
                        <small class="text-muted">{{ $order->created_at->format('M d, Y - h:i A') }}</small>
                    </div>
                    
                    @if($order->confirmed_at)
                        <div class="mb-3">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <strong>Confirmed</strong><br>
                            <small class="text-muted">{{ $order->confirmed_at->format('M d, Y - h:i A') }}</small>
                        </div>
                    @endif
                    
                    @if($order->delivered_at)
                        <div class="mb-3">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <strong>Delivered</strong><br>
                            <small class="text-muted">{{ $order->delivered_at->format('M d, Y - h:i A') }}</small>
                        </div>
                    @endif
                </div>
                
                <hr class="my-4">
                
                <!-- Payment Info -->
                <h6 class="fw-bold mb-3">Payment Information</h6>
                <p class="mb-1">
                    <strong>Method:</strong> Cash on Delivery
                </p>
                <p class="mb-0">
                    <strong>Status:</strong> 
                    <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection