@extends('restaurant.layouts.dashboard')

@section('title', 'Meals Management')
@section('page-title', 'Meals Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Your Menu</h4>
        <p class="text-muted mb-0">Manage your meals and menu items</p>
    </div>
    <a href="{{ route('restaurant.meals.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add New Meal
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($meals->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;">Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($meals as $meal)
                            <tr>
                                <td>
                                    @if($meal->image)
                                        <img src="{{ Storage::url($meal->image) }}" 
                                             class="rounded" 
                                             width="60" 
                                             height="60"
                                             style="object-fit: cover;"
                                             alt="{{ $meal->name }}">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                             style="width: 60px; height: 60px;">
                                            <i class="bi bi-egg-fried text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $meal->name }}</strong><br>
                                    <small class="text-muted">
                                        {{ Str::limit($meal->description, 50) }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ $meal->category->name }}
                                    </span>
                                </td>
                                <td>
                                    <strong class="text-primary">${{ number_format($meal->price, 2) }}</strong>
                                </td>
                                <td>
                                    @if($meal->is_available)
                                        <span class="badge bg-success">Available</span>
                                    @else
                                        <span class="badge bg-secondary">Unavailable</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('restaurant.meals.edit', $meal) }}" 
                                           class="btn btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('restaurant.meals.destroy', $meal) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Delete this meal?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">
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
                {{ $meals->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-egg-fried text-muted" style="font-size: 4rem;"></i>
                <h4 class="mt-3">No meals yet</h4>
                <p class="text-muted mb-4">Start building your menu by adding meals</p>
                <a href="{{ route('restaurant.meals.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add Your First Meal
                </a>
            </div>
        @endif
    </div>
</div>
@endsection