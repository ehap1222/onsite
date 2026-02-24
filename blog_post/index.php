<?php
require_once 'config/database.php';

// Fetch published posts with category names
$query = "SELECT p.*, c.name as category_name 
          FROM posts p 
          LEFT JOIN categories c ON p.category_id = c.id 
          WHERE p.status = 'published' 
          ORDER BY p.created_at DESC";
$posts = $pdo->query($query)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Blog System</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .hero { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 100px 0; }
        .post-card { transition: transform 0.2s; }
        .post-card:hover { transform: translateY(-5px); }
    </style>
</head>
<body class="bg-light">

    <!-- Primary Nav -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">PHP Blog</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin/index.php" target="_blank text-white">Admin Dashboard</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero text-center mb-5">
        <div class="container">
            <h1 class="display-3 fw-bold">Exploring Thoughts & Tech</h1>
            <p class="lead">Insights, tutorials, and more from the PHP Blog community.</p>
        </div>
    </header>

    <div class="container pb-5">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php if (empty($posts)): ?>
                <div class="col-12 text-center py-5">
                    <div class="alert alert-info py-5 px-4 shadow-sm">
                        <i class="bi bi-info-circle display-4 mb-3 d-block"></i>
                        <h4>No posts published yet.</h4>
                        <p class="mb-0">Check back later for exciting new content!</p>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm post-card">
                            <?php if ($post['image']): ?>
                                <img src="uploads/<?php echo $post['image']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($post['title']); ?>" style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="bi bi-image text-muted display-4"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2">
                                        <?php echo htmlspecialchars($post['category_name'] ?: 'General'); ?>
                                    </span>
                                    <small class="text-muted"><i class="bi bi-eye me-1"></i><?php echo $post['views']; ?></small>
                                </div>
                                <h4 class="card-title fw-bold mb-3"><?php echo htmlspecialchars($post['title']); ?></h4>
                                <p class="card-text text-muted">
                                    <?php 
                                        $excerpt = strip_tags($post['content']);
                                        echo (strlen($excerpt) > 120) ? substr($excerpt, 0, 117) . '...' : $excerpt;
                                    ?>
                                </p>
                            </div>
                            <div class="card-footer bg-transparent border-0 p-4 pt-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted small"><?php echo date('M j, Y', strtotime($post['created_at'])); ?></small>
                                    <a href="post.php?id=<?php echo $post['id']; ?>" class="btn btn-primary px-4 rounded-pill btn-sm">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-5 mt-5">
        <div class="container">
            <h5 class="fw-bold mb-3">PHP Blog System</h5>
            <p class="text-muted small mb-0">© 2025 All rights reserved. Created for the PHP Workshop.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
