<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - PHP Blog</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .sidebar { min-height: 100vh; }
        .nav-link.active { background-color: #f8f9fa; color: #0d6efd !important; font-weight: bold; }
        .card-stats { border-left: 4px solid #0d6efd; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-speedometer2 me-2"></i>Admin Dashboard
            </a>
            <div class="d-flex text-white me-3">
                <span class="me-3"><i class="bi bi-person-circle me-1"></i>Admin</span>
                <a href="../index.php" class="text-white text-decoration-none">
                    <i class="bi bi-box-arrow-right me-1"></i>Logout
                </a>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
