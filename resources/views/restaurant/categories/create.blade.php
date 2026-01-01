@extends('restaurant.layouts.dashboard')

@section('title', isset($category) ? 'Edit Category' : 'Add Category')
@section('page-title', isset($category) ? 'Edit Category' : 'Add Category')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ isset($category) ? route('restaurant.categories.update', $category) : route('restaurant.categories.store') }}" 
                      method="POST">
                    @csrf
                    @if(isset($category))
                        @method('PUT')
                    @endif
                    
                    <div class="mb-3">
                        <label class="form-label">Category Name *</label>
                        <input type="text" name="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $category->name ?? '') }}" 
                               placeholder="e.g., Breakfast, Lunch, Drinks"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="3" 
                                  class="form-control @error('description') is-invalid @enderror" 
                                  placeholder="Brief description of this category...">{{ old('description', $category->description ?? '') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" 
                               class="form-control @error('sort_order') is-invalid @enderror" 
                               value="{{ old('sort_order', $category->sort_order ?? 0) }}" 
                               min="0">
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Lower numbers appear first in the menu</small>
                    </div>
                    
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" 
                                   id="is_active" 
                                   {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active (visible to customers)
                            </label>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"
                                style="background-color: #ff6767; border-color: #ff6767;">
                            <i class="bi bi-check-circle"></i> 
                            {{ isset($category) ? 'Update' : 'Create' }} Category
                        </button>
                        <a href="{{ route('restaurant.categories.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
                
                @if(isset($category))
                    <!-- Delete Form (separate) -->
                    <form action="{{ route('restaurant.categories.destroy', $category) }}" 
                          method="POST" 
                          class="mt-3"
                          onsubmit="return confirm('Delete this category?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-trash"></i> Delete Category
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-lightbulb"></i> Category Tips
                </h6>
                <ul class="small">
                    <li class="mb-2"><strong>Common categories:</strong> Breakfast, Lunch, Dinner, Appetizers, Main Course, Desserts, Drinks, Specials</li>
                    <li class="mb-2"><strong>Sort order:</strong> Use numbers like 1, 2, 3 to control display order</li>
                    <li class="mb-2"><strong>Active/Inactive:</strong> Hide categories temporarily without deleting them</li>
                    <li class="mb-2"><strong>Organization:</strong> Keep categories clear and intuitive for customers</li>
                </ul>
                
                @if(isset($category))
                    <hr>
                    <h6 class="fw-bold mb-3">Category Stats</h6>
                    <p class="small mb-2">
                        <strong>Meals in category:</strong> {{ $category->meals()->count() }}
                    </p>
                    <p class="small mb-2">
                        <strong>Created:</strong> {{ $category->created_at->format('M d, Y') }}
                    </p>
                    <p class="small mb-0">
                        <strong>Last updated:</strong> {{ $category->updated_at->format('M d, Y') }}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection