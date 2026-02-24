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

        <style>
            body {
                font-family: 'Outfit', sans-serif;
                background-color: #f0f2f5;
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .auth-card {
                width: 100%;
                max-width: 400px;
                padding: 40px;
                background: white;
                border-radius: 15px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            }
            .btn-primary {
                background-color: #0d6efd;
                border: none;
                padding: 10px 20px;
                border-radius: 8px;
            }
        </style>
    </head>
    <body>
        <div class="auth-card">
            <div class="text-center mb-4">
                <h3 class="fw-bold">{{ config('app.name') }}</h3>
            </div>
            {{ $slot }}
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
