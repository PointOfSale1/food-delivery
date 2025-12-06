@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-circle text-primary" style="font-size: 3rem;"></i>
                        <h3 class="fw-bold mt-3">Welcome Back</h3>
                        <p class="text-muted">Login to your account</p>
                    </div>
                    
                    <form action="{{ route('login.submit') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" name="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}" 
                                       placeholder="your@email.com" 
                                       required autofocus>
                            </div>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" name="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="••••••••" 
                                       required>
                            </div>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </button>
                        
                        <div class="text-center">
                            <p class="text-muted mb-2">Don't have an account?</p>
                            <a href="{{ route('register') }}" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-person-plus"></i> Create Account
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