<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

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
            .sidebar {
                min-height: 100vh;
                background-color: #212529;
                color: white;
            }
            .sidebar a {
                color: #adb5bd;
                text-decoration: none;
                padding: 10px 20px;
                display: block;
                transition: 0.3s;
            }
            .sidebar a:hover, .sidebar a.active {
                color: white;
                background-color: #343a40;
            }
            .sidebar .nav-item {
                margin-bottom: 5px;
            }
            .content {
                padding: 20px;
            }
            .card {
                border: none;
                border-radius: 12px;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }
            .navbar {
                box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse p-0">
                    <div class="position-sticky pt-3">
                        <div class="px-3 mb-4">
                            <h5 class="text-white fw-bold">Admin Panel</h5>
                        </div>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                                    <i class="bi bi-grid me-2"></i> Categories
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('meals.*') ? 'active' : '' }}" href="{{ route('meals.index') }}">
                                    <i class="bi bi-egg-fried me-2"></i> Meals
                                </a>
                            </li>
                            <li class="nav-item mt-4">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Main Content -->
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <nav class="navbar navbar-expand-lg navbar-light bg-white mx-n4 px-4 py-3 mb-4">
                        <div class="container-fluid p-0">
                            <span class="navbar-brand mb-0 h1 fw-600">Restaurant Management</span>
                            <div class="d-flex align-items-center">
                                <span class="text-muted me-3">Welcome, {{ Auth::user()->name }}</span>
                                <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Profile</a>
                            </div>
                        </div>
                    </nav>

                    <div class="content">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </main>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
