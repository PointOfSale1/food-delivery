@extends('restaurant.layouts.dashboard')

@section('title', 'Edit Meal')
@section('page-title', 'Edit Meal')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('restaurant.meals.update', $meal) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-3">
                        <!-- Category -->
                        <div class="col-md-6">
                            <label class="form-label">Category *</label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id', $meal->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Name -->
                        <div class="col-md-6">
                            <label class="form-label">Meal Name *</label>
                            <input type="text" name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $meal->name) }}" 
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
                                   value="{{ old('price', $meal->price) }}" 
                                   step="0.01" 
                                   min="0"
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
                                   value="{{ old('sort_order', $meal->sort_order) }}" 
                                   min="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3" 
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $meal->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Ingredients -->
                        <div class="col-12">
                            <label class="form-label">Ingredients</label>
                            <textarea name="ingredients" rows="2" 
                                      class="form-control @error('ingredients') is-invalid @enderror">{{ old('ingredients', $meal->ingredients) }}</textarea>
                            @error('ingredients')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Current Image -->
                        @if($meal->image)
                            <div class="col-12">
                                <label class="form-label">Current Image</label>
                                <div>
                                    <img src="{{ Storage::url($meal->image) }}" 
                                         class="rounded" 
                                         width="200"
                                         alt="{{ $meal->name }}">
                                </div>
                            </div>
                        @endif
                        
                        <!-- New Image -->
                        <div class="col-12">
                            <label class="form-label">
                                {{ $meal->image ? 'Change Image' : 'Meal Image' }}
                            </label>
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
                                       id="is_available" {{ old('is_available', $meal->is_available) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_available">
                                    Available for ordering
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" style="background-color: #ff6767; border-color: #ff6767;">
                            <i class="bi bi-check-circle"></i> Update Meal
                        </button>
                        <a href="{{ route('restaurant.meals.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
                
                <!-- Delete Form (separate) -->
                <form action="{{ route('restaurant.meals.destroy', $meal) }}" 
                      method="POST" 
                      class="mt-3"
                      onsubmit="return confirm('Are you sure you want to delete this meal?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="bi bi-trash"></i> Delete Meal
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Meal Information</h6>
                <p class="small mb-2">
                    <strong>Created:</strong> {{ $meal->created_at->format('M d, Y') }}
                </p>
                <p class="small mb-2">
                    <strong>Last Updated:</strong> {{ $meal->updated_at->format('M d, Y') }}
                </p>
                <p class="small mb-0">
                    <strong>Category:</strong> {{ $meal->category->name }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection