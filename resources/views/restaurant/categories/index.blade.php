@extends('restaurant.layouts.dashboard')

@section('title', 'Categories Management')
@section('page-title', 'Categories Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Menu Categories</h4>
        <p class="text-muted mb-0">Organize your menu into categories</p>
    </div>
    <a href="{{ route('restaurant.categories.create') }}" class="btn btn-primary"
        style="background-color: #ff6767; border-color: #ff6767;">
        <i class="bi bi-plus-circle"></i> Add Category
    </a>
</div>

<div class="row g-4">
    @if($categories->count() > 0)
        @foreach($categories as $category)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="fw-bold mb-0">{{ $category->name }}</h5>
                            @if($category->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </div>
                        
                        @if($category->description)
                            <p class="text-muted small mb-3">{{ $category->description }}</p>
                        @endif
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted small">
                                <i class="bi bi-egg-fried"></i> {{ $category->meals_count }} meals
                            </span>
                            <span class="text-muted small">
                                Sort: {{ $category->sort_order }}
                            </span>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <a href="{{ route('restaurant.categories.edit', $category) }}" 
                               class="btn btn-sm btn-outline-primary flex-fill">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('restaurant.categories.destroy', $category) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Delete this category? All meals will remain but need reassignment.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-grid text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-3">No categories yet</h4>
                    <p class="text-muted mb-4">Create categories to organize your menu</p>
                    <a href="{{ route('restaurant.categories.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Create Your First Category
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection