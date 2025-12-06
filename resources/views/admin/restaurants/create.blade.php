@extends('admin.layouts.dashboard')

@section('title', 'Add New Restaurant')
@section('page-title', 'Add New Restaurant')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Restaurant Information</h5>
                
                <form action="{{ route('admin.restaurants.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row g-3">
                        <!-- Restaurant Name -->
                        <div class="col-md-6">
                            <label class="form-label">Restaurant Name *</label>
                            <input type="text" name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" 
                                   placeholder="e.g., Pizza Palace"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Email (Login Credential) -->
                        <div class="col-md-6">
                            <label class="form-label">Email (Login Credential) *</label>
                            <input type="email" name="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" 
                                   placeholder="restaurant@example.com"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Restaurant will use this email to login</small>
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
                        
                        <!-- Address -->
                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" 
                                   class="form-control @error('address') is-invalid @enderror" 
                                   value="{{ old('address') }}" 
                                   placeholder="123 Main Street">
                            @error('address')
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
                        
                        <!-- Logo -->
                        <div class="col-md-6">
                            <label class="form-label">Logo</label>
                            <input type="file" name="logo" 
                                   class="form-control @error('logo') is-invalid @enderror" 
                                   accept="image/jpeg,image/png,image/jpg">
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">JPG, JPEG or PNG. Max 2MB</small>
                        </div>
                        
                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      placeholder="Tell customers about this restaurant...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Create Restaurant
                        </button>
                        <a href="{{ route('admin.restaurants.index') }}" class="btn btn-outline-secondary">
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
                    <i class="bi bi-info-circle"></i> Important Notes
                </h6>
                <ul class="small">
                    <li class="mb-2"><strong>Email:</strong> Must be unique. Restaurant will use it to login.</li>
                    <li class="mb-2"><strong>Password:</strong> Will be securely hashed. Make sure to note it down!</li>
                    <li class="mb-2"><strong>Status:</strong> Restaurant will be set to "Active" by default.</li>
                    <li class="mb-2"><strong>Login URL:</strong> Restaurant can login at <code>/restaurant/login</code></li>
                    <li class="mb-0"><strong>After Creation:</strong> Share the email and password with the restaurant owner.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection