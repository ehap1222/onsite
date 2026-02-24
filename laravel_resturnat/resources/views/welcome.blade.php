<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Restaurant Management System</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

        <style>
            body {
                font-family: 'Outfit', sans-serif;
                background-color: #f8f9fa;
            }
            .hero {
                background: linear-gradient(135deg, #1a1a1a 0%, #3d3d3d 100%);
                color: white;
                padding: 100px 0;
                margin-bottom: 50px;
            }
            .card {
                border: none;
                border-radius: 15px;
                transition: transform 0.3s ease;
                overflow: hidden;
                box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            }
            .card:hover {
                transform: translateY(-10px);
            }
            .meal-img {
                height: 200px;
                object-fit: cover;
            }
            .category-btn {
                border-radius: 30px;
                padding: 8px 25px;
                margin-bottom: 10px;
            }
            .price-badge {
                position: absolute;
                top: 15px;
                right: 15px;
                background: rgba(255,255,255,0.9);
                padding: 5px 15px;
                border-radius: 20px;
                font-weight: bold;
                color: #212529;
            }
            .navbar {
                background: #ffffff;
                box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            }
        </style>
    </head>
    <body class="antialiased">
        <nav class="navbar navbar-expand-lg navbar-light sticky-top">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                    <i class="bi bi-restaurant me-2"></i>Restaurant
                </a>
                <div class="d-flex align-items-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-link text-decoration-none text-dark me-2">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm rounded-pill px-4">Register</a>
                    @endauth
                </div>
            </div>
        </nav>

        <header class="hero text-center">
            <div class="container">
                <h1 class="display-4 fw-bold mb-3">Delicious Meals for Every Taste</h1>
                <p class="lead mb-4">Explore our wide selection of categories and find your favorite dish.</p>
                <div class="d-flex justify-content-center flex-wrap gap-2">
                    <a href="{{ route('home') }}" class="btn btn-{{ !isset($category) ? 'primary' : 'outline-primary' }} category-btn">All Meals</a>
                    @foreach($categories as $cat)
                        <a href="{{ route('category.meals', $cat->id) }}" class="btn btn-{{ isset($category) && $category->id == $cat->id ? 'primary' : 'outline-primary' }} category-btn">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </header>

        <main class="container mb-5">
            <div class="row g-4">
                @forelse($meals as $meal)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                            <div class="position-relative">
                                @if($meal->image)
                                    <img src="{{ asset('storage/' . $meal->image) }}" class="card-img-top meal-img" alt="{{ $meal->name }}">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center meal-img">
                                        <i class="bi bi-image text-muted display-4"></i>
                                    </div>
                                @endif
                                <span class="price-badge">${{ number_format($meal->price, 2) }}</span>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="card-title fw-bold mb-0">{{ $meal->name }}</h5>
                                    <span class="badge bg-light text-dark">{{ $meal->category->name }}</span>
                                </div>
                                <p class="card-text text-muted">{{ $meal->description }}</p>
                            </div>
                            <div class="card-footer bg-white border-0 pb-4">
                                <button class="btn btn-outline-dark w-100 rounded-pill">Order Now</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="mb-4 text-muted">
                            <i class="bi bi-search display-1"></i>
                        </div>
                        <h3>No meals found</h3>
                        <p class="text-muted">Try selective a different category or check back later.</p>
                        <a href="{{ route('home') }}" class="btn btn-primary mt-3">Reset Filters</a>
                    </div>
                @endforelse
            </div>
        </main>

        <footer class="bg-dark text-white py-4 mt-auto">
            <div class="container text-center">
                <p class="mb-0">&copy; {{ date('Y') }} Restaurant Management System. All rights reserved.</p>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
