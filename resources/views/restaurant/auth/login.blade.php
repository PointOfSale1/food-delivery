<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Login</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            background: linear-gradient(180deg, #FFF3E6 0%, #FFF8F1 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 60px 0;
        }
        
        .login-card {
            border-radius: 18px;
            box-shadow: 0 15px 45px rgba(0,0,0,0.25);
        }

        .btn-primary {
            background-color: #F28482;
            border: none;
        }

        .btn-primary:hover {
            background-color: #FF5252;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card login-card border-0">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="mb-3">
                                <i class="bi bi-shop text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h3 class="fw-bold">Restaurant Login</h3>
                            <p class="text-muted">Sign in to manage your restaurant</p>
                        </div>
                        
                        @if(session('success'))
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle"></i> {{ session('success') }}
                            </div>
                        @endif
                        
                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <div><i class="bi bi-exclamation-circle"></i> {{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                        
                        <form action="{{ route('restaurant.login.submit') }}" method="POST">
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
                                           placeholder="restaurant@example.com" 
                                           required autofocus>
                                </div>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
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
                            
                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </button>
                            
                            <div class="text-center">
                                <a href="{{ route('home') }}" class="text-decoration-none text-muted">
                                    <i class="bi bi-arrow-left"></i> Back to Website
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="text-center mt-3 text-black">
                    <small>
                        Test credentials: pizza@example.com / password123
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>