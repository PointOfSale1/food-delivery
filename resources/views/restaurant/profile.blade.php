@extends('restaurant.layouts.dashboard')

@section('title', 'Restaurant Profile')
@section('page-title', 'Restaurant Profile')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Restaurant Information</h5>
                
                <form action="{{ route('restaurant.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-3">
                        <!-- Name -->
                        <div class="col-md-6">
                            <label class="form-label">Restaurant Name *</label>
                            <input type="text" name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $restaurant->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $restaurant->email) }}" 
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
                                   value="{{ old('phone', $restaurant->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- City -->
                        <div class="col-md-6">
                            <label class="form-label">City</label>
                            <input type="text" name="city" 
                                   class="form-control @error('city') is-invalid @enderror" 
                                   value="{{ old('city', $restaurant->city) }}">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Address -->
                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <textarea name="address" rows="2" 
                                      class="form-control @error('address') is-invalid @enderror">{{ old('address', $restaurant->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      placeholder="Tell customers about your restaurant...">{{ old('description', $restaurant->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Current Logo -->
                        @if($restaurant->logo)
                            <div class="col-12">
                                <label class="form-label">Current Logo</label>
                                <div class="mb-2">
                                    <img src="{{ Storage::url($restaurant->logo) }}" 
                                         class="rounded" 
                                         width="150"
                                         alt="{{ $restaurant->name }}">
                                </div>
                            </div>
                        @endif
                        
                        <!-- New Logo -->
                        <div class="col-12">
                            <label class="form-label">
                                {{ $restaurant->logo ? 'Change Logo' : 'Upload Logo' }}
                            </label>
                            <input type="file" name="logo" 
                                   class="form-control @error('logo') is-invalid @enderror" 
                                   accept="image/jpeg,image/png,image/jpg">
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">JPG, JPEG or PNG. Max 2MB</small>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <h5 class="fw-bold mb-4">Change Password</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="Leave blank to keep current">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimum 6 characters</small>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" 
                                   class="form-control" 
                                   placeholder="Confirm new password">
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <button type="submit" class="btn btn-primary"
                            style="background-color: #ff6767; border-color: #ff6767;">
                        <i class="bi bi-check-circle"></i> Update Profile
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Account Status</h6>
                <p class="mb-2">
                    <strong>Status:</strong> 
                    <span class="badge bg-{{ $restaurant->status == 'active' ? 'success' : 'secondary' }}">
                        {{ ucfirst($restaurant->status) }}
                    </span>
                </p>
                <p class="mb-2">
                    <strong>Member since:</strong><br>
                    {{ $restaurant->created_at->format('M d, Y') }}
                </p>
                <p class="mb-0">
                    <strong>Last updated:</strong><br>
                    {{ $restaurant->updated_at->format('M d, Y') }}
                </p>
            </div>
        </div>
        
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-shield-check"></i> Security Tips
                </h6>
                <ul class="small mb-0">
                    <li class="mb-2">Use a strong, unique password</li>
                    <li class="mb-2">Never share your login credentials</li>
                    <li class="mb-2">Keep your contact info up to date</li>
                    <li class="mb-0">Log out when using shared devices</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection