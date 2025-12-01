@extends('layouts.app')

@section('title', $meal->name)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="row g-0">
                    <!-- Meal Image -->
                    <div class="col-md-6">
                        @if($meal->image)
                            <img src="{{ Storage::url($meal->image) }}" 
                                 class="img-fluid rounded-start h-100 w-100" 
                                 alt="{{ $meal->name }}"
                                 style="object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                <i class="bi bi-egg-fried text-muted" style="font-size: 6rem;"></i>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Meal Details -->
                    <div class="col-md-6">
                        <div class="card-body p-4">
                            <!-- Restaurant Info -->
                            <div class="mb-3">
                                <a href="{{ route('restaurants.show', $meal->restaurant) }}" 
                                   class="text-decoration-none text-muted">
                                    <i class="bi bi-shop"></i> {{ $meal->restaurant->name }}
                                </a>
                            </div>
                            
                            <!-- Meal Name -->
                            <h2 class="fw-bold mb-3">{{ $meal->name }}</h2>
                            
                            <!-- Category -->
                            <p class="text-muted mb-3">
                                <i class="bi bi-tag"></i> {{ $meal->category->name }}
                            </p>
                            
                            <!-- Description -->
                            @if($meal->description)
                                <div class="mb-4">
                                    <h5 class="fw-bold">Description</h5>
                                    <p class="text-muted">{{ $meal->description }}</p>
                                </div>
                            @endif
                            
                            <!-- Ingredients -->
                            @if($meal->ingredients)
                                <div class="mb-4">
                                    <h5 class="fw-bold">Ingredients</h5>
                                    <p class="text-muted">{{ $meal->ingredients }}</p>
                                </div>
                            @endif
                            
                            <!-- Price -->
                            <div class="mb-4">
                                <h3 class="text-primary fw-bold">
                                    ${{ number_format($meal->price, 2) }}
                                </h3>
                            </div>
                            
                            <!-- Add to Cart Form -->
                            <form action="{{ route('cart.add', $meal) }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Quantity</label>
                                        <input type="number" name="quantity" class="form-control" 
                                               value="1" min="1" max="99" required>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label fw-bold">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="bi bi-cart-plus"></i> Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </form>
                            
                            <!-- Back Button -->
                            <div class="mt-4">
                                <a href="{{ route('restaurants.show', $meal->restaurant) }}" 
                                   class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-arrow-left"></i> Back to Menu
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection