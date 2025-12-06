@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-plus-fill text-primary" style="font-size: 3rem;"></i>
                        <h3 class="fw-bold mt-3">Create Account</h3>
                        <p class="text-muted">Join us and start ordering!</p>
                    </div>
                    
                    <form action="{{ route('register.submit') }}" method="POST">
                        @csrf
                        
                        <div class="row g-3">
                            <!-- Name -->
                            <div class="col-12">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" 
                                       placeholder="John Doe" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Email -->
                            <div class="col-12">
                                <label class="form-label">Email Address *</label>
                                <input type="email" name="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}" 
                                       placeholder="your@email.com" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Password -->
                            <div class="col-md-6">
                                <label class="form-label">Password *</label>
                                <input type="password" name="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="••••••••" 
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Minimum 6 characters</small>
                            </div>
                            
                            <!-- Confirm Password -->
                            <div class="col-md-6">
                                <label class="form-label">Confirm Password *</label>
                                <input type="password" name="password_confirmation" 
                                       class="form-control" 
                                       placeholder="••••••••" 
                                       required>
                            </div>
                            
                            <!-- Phone -->
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" name="phone" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone') }}" 
                                       placeholder="555-1234">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- City -->
                            <div class="col-md-6">
                                <label class="form-label">City</label>
                                <input type="text" name="city" 
                                       class="form-control @error('city') is-invalid @enderror" 
                                       value="{{ old('city') }}" 
                                       placeholder="New York">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Address -->
                            <div class="col-12">
                                <label class="form-label">Delivery Address</label>
                                <textarea name="address" rows="2" 
                                          class="form-control @error('address') is-invalid @enderror" 
                                          placeholder="123 Main Street, Apt 4B">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">This will be used as your default delivery address</small>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="bi bi-person-check"></i> Create Account
                        </button>
                        
                        <div class="text-center">
                            <p class="text-muted mb-2">Already have an account?</p>
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-box-arrow-in-right"></i> Login Instead
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="text-center mt-3">
                <a href="{{ route('home') }}" class="text-decoration-none text-muted">
                    <i class="bi bi-arrow-left"></i> Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection