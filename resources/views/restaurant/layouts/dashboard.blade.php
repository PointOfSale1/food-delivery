<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Restaurant Dashboard')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #ff6767ff 0%, #F28482 100%);
            padding: 0;
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 1rem 1.5rem;
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.1);
            border-left-color: white;
        }
        
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
        }
        
        .main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        
        .stat-card {
            border-left: 4px solid;
            transition: transform 0.2s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .badge-status {
            padding: 0.5rem 1rem;
            border-radius: 50px;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="p-4">
                    <h4 class="text-white mb-4">
                        <i class="bi bi-shop"></i> Dashboard
                    </h4>
                    <p class="text-white-50 small mb-4">
                        {{ session('restaurant_name') }}
                    </p>
                </div>
                
                <nav class="nav flex-column">
                    <a class="nav-link {{ request()->routeIs('restaurant.dashboard') ? 'active' : '' }}" 
                       href="{{ route('restaurant.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a class="nav-link {{ request()->routeIs('restaurant.orders.*') ? 'active' : '' }}" 
                       href="{{ route('restaurant.orders.index') }}">
                        <i class="bi bi-bag"></i> Orders
                    </a>
                    <a class="nav-link {{ request()->routeIs('restaurant.meals.*') ? 'active' : '' }}" 
                       href="{{ route('restaurant.meals.index') }}">
                        <i class="bi bi-egg-fried"></i> Meals
                    </a>
                    <a class="nav-link {{ request()->routeIs('restaurant.categories.*') ? 'active' : '' }}" 
                       href="{{ route('restaurant.categories.index') }}">
                        <i class="bi bi-grid"></i> Categories
                    </a>
                    <a class="nav-link {{ request()->routeIs('restaurant.profile') ? 'active' : '' }}" 
                       href="{{ route('restaurant.profile') }}">
                        <i class="bi bi-gear"></i> Profile
                    </a>
                    
                    <hr class="text-white-50 my-3">
                    
                    <form action="{{ route('restaurant.logout') }}" method="POST">
                        @csrf
                        <button class="nav-link border-0 bg-transparent w-100 text-start" type="submit">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </nav>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <!-- Top Navigation -->
                <nav class="navbar navbar-light bg-white shadow-sm sticky-top mb-4">
                    <div class="container-fluid">
                        <span class="navbar-brand mb-0 h1">@yield('page-title', 'Dashboard')</span>
                        <div class="d-flex align-items-center">
                            <span class="text-muted me-3">
                                <i class="bi bi-person-circle"></i> {{ session('restaurant_name') }}
                            </span>
                        </div>
                    </div>
                </nav>
                
                <!-- Alert Messages -->
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle"></i>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                </div>
                
                <!-- Page Content -->
                <div class="container-fluid pb-5">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>