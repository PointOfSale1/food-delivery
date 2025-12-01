@extends('layouts.app')

@section('title', 'Home - Browse Restaurants')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-4 fw-bold mb-3">Order Food from Your Favorite Restaurants</h1>
            <p class="lead text-muted">Fast delivery, great food, amazing service</p>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-lg-6 mx-auto">
            <form action="{{ route('home') }}" method="GET">
                <div class="input-group input-group-lg shadow-sm">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search restaurants by name or location..." 
                           value="{{ $search ?? '' }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Restaurants Grid -->
    @if($restaurants->count() > 0)
        <div class="row g-4">
            @foreach($restaurants as $restaurant)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        @if($restaurant->logo)
                            <img src="{{ Storage::url($restaurant->logo) }}" 
                                 class="card-img-top" 
                                 alt="{{ $restaurant->name }}"
                                 style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                 style="height: 200px;">
                                <i class="bi bi-shop text-muted" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                        
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $restaurant->name }}</h5>
                            
                            <p class="text-muted small mb-2">
                                <i class="bi bi-geo-alt"></i> {{ $restaurant->city }}
                            </p>
                            
                            @if($restaurant->description)
                                <p class="card-text text-muted small">
                                    {{ Str::limit($restaurant->description, 80) }}
                                </p>
                            @endif
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="badge bg-success">
                                    <i class="bi bi-clock"></i> Open
                                </span>
                                <a href="{{ route('restaurants.show', $restaurant) }}" 
                                   class="btn btn-primary btn-sm">
                                    View Menu <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-5 d-flex justify-content-center">
            {{ $restaurants->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-search text-muted" style="font-size: 4rem;"></i>
            <h3 class="mt-3">No restaurants found</h3>
            <p class="text-muted">Try searching with different keywords</p>
            @if($search)
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> View All Restaurants
                </a>
            @endif
        </div>
    @endif
</div>
@endsection