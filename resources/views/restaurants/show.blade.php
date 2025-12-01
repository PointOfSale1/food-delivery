@extends('layouts.app')

@section('title', $restaurant->name . ' - Menu')

@section('content')
<div class="container">
    <!-- Restaurant Header -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            @if($restaurant->logo)
                                <img src="{{ Storage::url($restaurant->logo) }}" 
                                     class="img-fluid rounded" 
                                     alt="{{ $restaurant->name }}">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                     style="height: 100px;">
                                    <i class="bi bi-shop text-muted" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-10">
                            <h2 class="fw-bold mb-2">{{ $restaurant->name }}</h2>
                            <p class="text-muted mb-2">
                                <i class="bi bi-geo-alt"></i> {{ $restaurant->address }}, {{ $restaurant->city }}
                            </p>
                            @if($restaurant->phone)
                                <p class="text-muted mb-2">
                                    <i class="bi bi-telephone"></i> {{ $restaurant->phone }}
                                </p>
                            @endif
                            @if($restaurant->description)
                                <p class="mb-0">{{ $restaurant->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Categories -->
    @if($categories->count() > 0)
        @foreach($categories as $category)
            @if($category->meals->count() > 0)
                <div class="row mb-5">
                    <div class="col-lg-12">
                        <h3 class="fw-bold mb-4">
                            <i class="bi bi-grid"></i> {{ $category->name }}
                        </h3>
                        
                        <div class="row g-4">
                            @foreach($category->meals as $meal)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100 border-0 shadow-sm">
                                        @if($meal->image)
                                            <img src="{{ Storage::url($meal->image) }}" 
                                                 class="card-img-top" 
                                                 alt="{{ $meal->name }}"
                                                 style="height: 180px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="height: 180px;">
                                                <i class="bi bi-egg-fried text-muted" style="font-size: 3rem;"></i>
                                            </div>
                                        @endif
                                        
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title fw-bold">{{ $meal->name }}</h5>
                                            
                                            @if($meal->description)
                                                <p class="card-text text-muted small flex-grow-1">
                                                    {{ Str::limit($meal->description, 60) }}
                                                </p>
                                            @endif
                                            
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <span class="h5 text-primary mb-0 fw-bold">
                                                    ${{ number_format($meal->price, 2) }}
                                                </span>
                                                <a href="{{ route('meals.show', $meal) }}" 
                                                   class="btn btn-primary btn-sm">
                                                    <i class="bi bi-plus-circle"></i> Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <div class="text-center py-5">
            <i class="bi bi-egg-fried text-muted" style="font-size: 4rem;"></i>
            <h3 class="mt-3">No menu available</h3>
            <p class="text-muted">This restaurant hasn't added any meals yet</p>
        </div>
    @endif

    <!-- Back Button -->
    <div class="text-center mt-4">
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Restaurants
        </a>
    </div>
</div>
@endsection