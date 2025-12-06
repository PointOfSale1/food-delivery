@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h2 class="fw-bold mb-4">
                <i class="bi bi-person-circle"></i> My Profile
            </h2>
            
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Account Information</h5>
                    
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <!-- Name -->
                            <div class="col-md-6">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', auth()->user()->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label">Email Address *</label>
                                <input type="email" name="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', auth()->user()->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Phone -->
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" name="phone" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone', auth()->user()->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- City -->
                            <div class="col-md-6">
                                <label class="form-label">City</label>
                                <input type="text" name="city" 
                                       class="form-control @error('city') is-invalid @enderror" 
                                       value="{{ old('city', auth()->user()->city) }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Address -->
                            <div class="col-12">
                                <label class="form-label">Delivery Address</label>
                                <textarea name="address" rows="2" 
                                          class="form-control @error('address') is-invalid @enderror">{{ old('address', auth()->user()->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <h5 class="fw-bold mb-4">Change Password</h5>
                        <p class="text-muted small">Leave blank to keep current password</p>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">New Password</label>
                                <input type="password" name="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="Leave blank to keep current">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" name="password_confirmation" 
                                       class="form-control" 
                                       placeholder="Confirm new password">
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Update Profile
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Account Stats -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Account Statistics</h5>
                    
                    <div class="row text-center g-3">
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <h3 class="fw-bold text-primary mb-1">{{ auth()->user()->orders()->count() }}</h3>
                                <small class="text-muted">Total Orders</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <h3 class="fw-bold text-success mb-1">${{ number_format(auth()->user()->orders()->where('status', 'delivered')->sum('total'), 2) }}</h3>
                                <small class="text-muted">Total Spent</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <h3 class="fw-bold text-info mb-1">{{ auth()->user()->created_at->diffForHumans() }}</h3>
                                <small class="text-muted">Member Since</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection