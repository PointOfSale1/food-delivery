@extends('admin.layouts.dashboard')

@section('title', 'Manage Restaurants')
@section('page-title', 'Restaurants Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">All Restaurants</h4>
        <p class="text-muted mb-0">Manage restaurant accounts and settings</p>
    </div>
    <a href="{{ route('admin.restaurants.create') }}" class="btn btn-primary"
        style="background-color: #ff6767; border-color: #ff6767;">
        <i class="bi bi-plus-circle"></i> Add New Restaurant
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($restaurants->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Restaurant</th>
                            <th>Email</th>
                            <th>City</th>
                            <th>Orders</th>
                            <th>Meals</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($restaurants as $restaurant)
                            <tr>
                                <td><strong>#{{ $restaurant->id }}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($restaurant->logo)
                                            <img src="{{ Storage::url($restaurant->logo) }}" 
                                                 class="rounded me-2" 
                                                 width="40" height="40"
                                                 style="object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="bi bi-shop text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $restaurant->name }}</strong><br>
                                            @if($restaurant->phone)
                                                <small class="text-muted">{{ $restaurant->phone }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $restaurant->email }}</td>
                                <td>{{ $restaurant->city ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $restaurant->orders_count }} orders</span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $restaurant->meals_count }} meals</span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $restaurant->status == 'active' ? 'success' : 'danger' }}">
                                        {{ ucfirst($restaurant->status) }}
                                    </span>
                                </td>
                                <td>
                                    <small>{{ $restaurant->created_at->format('M d, Y') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.restaurants.show', $restaurant) }}" 
                                           class="btn btn-outline-info"
                                           title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.restaurants.edit', $restaurant) }}" 
                                           class="btn btn-outline-primary"
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.restaurants.destroy', $restaurant) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Delete this restaurant? All associated data will be deleted.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-3">
                {{ $restaurants->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-shop text-muted" style="font-size: 4rem;"></i>
                <h4 class="mt-3">No restaurants yet</h4>
                <p class="text-muted mb-4">Add your first restaurant to get started</p>
                <a href="{{ route('admin.restaurants.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add First Restaurant
                </a>
            </div>
        @endif
    </div>
</div>
@endsection