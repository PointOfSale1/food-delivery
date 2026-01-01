@extends('admin.layouts.dashboard')

@section('title', 'Edit Restaurant')
@section('page-title', 'Edit Restaurant')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Edit Restaurant Information</h5>
                
                <form action="{{ route('admin.restaurants.update', $restaurant) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-3">
                        <!-- Restaurant Name -->
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
                            <label class="form-label">Email (Login Credential) *</label>
                            <input type="email" name="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $restaurant->email) }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Password -->
                        <div class="col-md-6">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="Leave blank to keep current">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Only fill if changing password</small>
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
                        
                        <!-- Address -->
                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" 
                                   class="form-control @error('address') is-invalid @enderror" 
                                   value="{{ old('address', $restaurant->address) }}">
                            @error('address')
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
                        
                        <!-- Status -->
                        <div class="col-md-6">
                            <label class="form-label">Status *</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="active" {{ old('status', $restaurant->status) == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="inactive" {{ old('status', $restaurant->status) == 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Current Logo -->
                        @if($restaurant->logo)
                            <div class="col-12">
                                <label class="form-label">Current Logo</label>
                                <div>
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
                        
                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3" 
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $restaurant->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"
                                style="background-color: #ff6767; border-color: #ff6767;">
                            <i class="bi bi-check-circle"></i> Update Restaurant
                        </button>
                        <a href="{{ route('admin.restaurants.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
                
                <!-- Delete Form -->
                <form action="{{ route('admin.restaurants.destroy', $restaurant) }}" 
                      method="POST" 
                      class="mt-3"
                      onsubmit="return confirm('Delete this restaurant? All associated data will be deleted.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="bi bi-trash"></i> Delete Restaurant
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Restaurant Statistics</h6>
                <p class="mb-2">
                    <strong>Total Orders:</strong> {{ $restaurant->orders()->count() }}
                </p>
                <p class="mb-2">
                    <strong>Total Meals:</strong> {{ $restaurant->meals()->count() }}
                </p>
                <p class="mb-2">
                    <strong>Categories:</strong> {{ $restaurant->categories()->count() }}
                </p>
                <p class="mb-0">
                    <strong>Created:</strong> {{ $restaurant->created_at->format('M d, Y') }}
                </p>
            </div>
        </div>
        
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Quick Actions</h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.restaurants.show', $restaurant) }}" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-eye"></i> View Full Details
                    </a>
                    <a href="{{ route('restaurants.show', $restaurant) }}" 
                       class="btn btn-outline-secondary btn-sm" 
                       target="_blank">
                        <i class="bi bi-box-arrow-up-right"></i> View on Website
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection