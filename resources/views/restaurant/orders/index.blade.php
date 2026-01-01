@extends('restaurant.layouts.dashboard')

@section('title', 'Orders Management')
@section('page-title', 'Orders Management')

@section('content')
<!-- Status Filter Tabs -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <ul class="nav nav-pills">
            @php
                $statuses = ['all' => 'All Orders', 'pending' => 'Pending', 'confirmed' => 'Confirmed', 'preparing' => 'Preparing', 'delivered' => 'Delivered'];
            @endphp

            @foreach($statuses as $key => $label)
                <li class="nav-item">
                    <a class="nav-link {{ request('status', 'all') == $key ? 'active' : '' }}" 
                    href="{{ route('restaurant.orders.index', $key !== 'all' ? ['status' => $key] : []) }}"
                    style="{{ request('status', 'all') == $key 
                                ? 'background-color: #ff6767; border-color: #ff6767; color: white;' 
                                : 'color: #6c757d;' }}"> <!-- gray color for inactive -->
                        {{ $label }} ({{ $statusCounts[$key] }})
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<!-- Orders Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>
                                    <strong>{{ $order->order_number }}</strong>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $order->customer_name }}</strong><br>
                                        <small class="text-muted">
                                            <i class="bi bi-telephone"></i> {{ $order->customer_phone }}
                                        </small>
                                    </div>
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
                                    <small>{{ $order->created_at->format('M d, Y') }}</small><br>
                                    <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                </td>
                                <td>
                                    <a href="{{ route('restaurant.orders.show', $order) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-3">
                {{ $orders->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                <h4 class="mt-3">No orders found</h4>
                <p class="text-muted">Orders will appear here once customers place them</p>
            </div>
        @endif
    </div>
</div>
@endsection