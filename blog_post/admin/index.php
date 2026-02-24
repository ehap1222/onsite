<?php
require_once '../config/database.php';

// Fetch summary counts for dashboard cards
$totalPosts = $pdo->query("SELECT COUNT(*) FROM posts")->fetchColumn();
$totalCats = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
$totalComments = $pdo->query("SELECT COUNT(*) FROM comments")->fetchColumn();
$pendingComments = $pdo->query("SELECT COUNT(*) FROM comments WHERE status = 'pending'")->fetchColumn();

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard Overview</h1>
    </div>

    <!-- Stats Cards -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4 mt-2">
        <div class="col">
            <div class="card h-100 border-0 shadow-sm card-stats border-primary">
                <div class="card-body">
                    <h5 class="card-title text-muted">Total Posts</h5>
                    <h2 class="mb-0 fw-bold"><?php echo $totalPosts; ?></h2>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 border-0 shadow-sm card-stats border-success">
                <div class="card-body">
                    <h5 class="card-title text-muted">Categories</h5>
                    <h2 class="mb-0 fw-bold"><?php echo $totalCats; ?></h2>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 border-0 shadow-sm card-stats border-info">
                <div class="card-body">
                    <h5 class="card-title text-muted">Total Comments</h5>
                    <h2 class="mb-0 fw-bold"><?php echo $totalComments; ?></h2>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 border-0 shadow-sm card-stats border-warning">
                <div class="card-body">
                    <h5 class="card-title text-muted">Pending Review</h5>
                    <h2 class="mb-0 fw-bold"><?php echo $pendingComments; ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h4>Quick Actions</h4>
        <div class="d-flex gap-2 mt-3">
            <a href="addpost.php" class="btn btn-primary">Add New Post</a>
            <a href="categories.php" class="btn btn-outline-secondary">Manage Categories</a>
            <a href="comments.php" class="btn btn-outline-info">Review Comments</a>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
