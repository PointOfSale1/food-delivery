@extends('restaurant.layouts.dashboard')

@section('title', 'Add New Meal')
@section('page-title', 'Add New Meal')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('restaurant.meals.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row g-3">
                        <!-- Category -->
                        <div class="col-md-6">
                            <label class="form-label">Category *</label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                No categories? <a href="{{ route('restaurant.categories.create') }}">Create one first</a>
                            </small>
                        </div>
                        
                        <!-- Name -->
                        <div class="col-md-6">
                            <label class="form-label">Meal Name *</label>
                            <input type="text" name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" 
                                   placeholder="e.g., Margherita Pizza"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Price -->
                        <div class="col-md-6">
                            <label class="form-label">Price ($) *</label>
                            <input type="number" name="price" 
                                   class="form-control @error('price') is-invalid @enderror" 
                                   value="{{ old('price') }}" 
                                   step="0.01" 
                                   min="0"
                                   placeholder="9.99"
                                   required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Sort Order -->
                        <div class="col-md-6">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" 
                                   class="form-control @error('sort_order') is-invalid @enderror" 
                                   value="{{ old('sort_order', 0) }}" 
                                   min="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Lower numbers appear first</small>
                        </div>
                        
                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      placeholder="Brief description of the meal...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Ingredients -->
                        <div class="col-12">
                            <label class="form-label">Ingredients</label>
                            <textarea name="ingredients" rows="2" 
                                      class="form-control @error('ingredients') is-invalid @enderror" 
                                      placeholder="List ingredients...">{{ old('ingredients') }}</textarea>
                            @error('ingredients')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Image -->
                        <div class="col-12">
                            <label class="form-label">Meal Image</label>
                            <input type="file" name="image" 
                                   class="form-control @error('image') is-invalid @enderror" 
                                   accept="image/jpeg,image/png,image/jpg">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">JPG, JPEG or PNG. Max 2MB</small>
                        </div>
                        
                        <!-- Availability -->
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_available" 
                                       id="is_available" {{ old('is_available', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_available">
                                    Available for ordering
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" style="background-color: #ff6767; border-color: #ff6767;">
                            <i class="bi bi-check-circle"></i> Add Meal
                        </button>
                        <a href="{{ route('restaurant.meals.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-info-circle"></i> Tips
                </h6>
                <ul class="small">
                    <li class="mb-2">Use high-quality images to attract customers</li>
                    <li class="mb-2">Write clear, appetizing descriptions</li>
                    <li class="mb-2">List all ingredients for transparency</li>
                    <li class="mb-2">Set competitive prices</li>
                    <li class="mb-2">Use sort order to highlight popular items</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection