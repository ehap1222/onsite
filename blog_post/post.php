<?php
require_once 'config/database.php';

$id = (int)($_GET['id'] ?? 0);
$success_msg = '';

// Handle Comment Posting
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $comment = trim($_POST['comment']);
    
    if (!empty($name) && !empty($email) && !empty($comment)) {
        $stmt = $pdo->prepare("INSERT INTO comments (post_id, name, email, comment, status) VALUES (?, ?, ?, ?, 'pending')");
        $stmt->execute([$id, $name, $email, $comment]);
        $success_msg = "Your comment has been submitted and is awaiting approval.";
    }
}

// Fetch Post
$stmt = $pdo->prepare("SELECT p.*, c.name as category_name 
                       FROM posts p 
                       LEFT JOIN categories c ON p.category_id = c.id 
                       WHERE p.id = ? AND p.status = 'published'");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    header("Location: index.php");
    exit();
}

// Increment View Count
$pdo->prepare("UPDATE posts SET views = views + 1 WHERE id = ?")->execute([$id]);

// Fetch Approved Comments
$commStmt = $pdo->prepare("SELECT * FROM comments WHERE post_id = ? AND status = 'approved' ORDER BY created_at DESC");
$commStmt->execute([$id]);
$comments = $commStmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> | PHP Blog</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <!-- Nav -->
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

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Post Header -->
                <header class="mb-5">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Home</a></li>
                            <li class="breadcrumb-item active"><?php echo htmlspecialchars($post['category_name'] ?: 'Tech'); ?></li>
                        </ol>
                    </nav>
                    <h1 class="display-4 fw-bold mb-3"><?php echo htmlspecialchars($post['title']); ?></h1>
                    <div class="d-flex align-items-center text-muted small">
                        <span class="me-3"><i class="bi bi-calendar-event me-2"></i><?php echo date('F j, Y', strtotime($post['created_at'])); ?></span>
                        <span class="me-3"><i class="bi bi-eye me-2"></i><?php echo ($post['views'] + 1); ?> views</span>
                        <span><i class="bi bi-chat-left-text me-2"></i><?php echo count($comments); ?> comments</span>
                    </div>
                </header>

                <!-- Post Image -->
                <?php if ($post['image']): ?>
                    <img src="uploads/<?php echo $post['image']; ?>" class="img-fluid rounded-4 shadow-sm mb-5 w-100" alt="<?php echo htmlspecialchars($post['title']); ?>" style="max-height: 500px; object-fit: cover;">
                <?php endif; ?>

                <!-- Post Content -->
                <article class="lh-lg fs-5 text-secondary mb-5" style="white-space: pre-line;">
                    <?php echo htmlspecialchars($post['content']); ?>
                </article>

                <hr class="my-5">

                <!-- Comments Section -->
                <section class="comments-section">
                    <h3 class="fw-bold mb-4">Comments (<?php echo count($comments); ?>)</h3>

                    <?php if ($success_msg): ?>
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i><?php echo $success_msg; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Comment Form -->
                    <div class="card border-0 shadow-sm mb-5 p-4">
                        <h5 class="fw-bold mb-3">Leave a Reply</h5>
                        <form method="POST">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold">Comment</label>
                                    <textarea name="comment" class="form-control" rows="4" placeholder="Your beautiful thoughts here..." required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" name="submit_comment" class="btn btn-primary px-4 py-2">Post Comment</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Comments List -->
                    <div class="comments-list">
                        <?php if (empty($comments)): ?>
                            <p class="text-muted fst-italic">Be the first to share your thoughts!</p>
                        <?php else: ?>
                            <?php foreach ($comments as $comm): ?>
                                <div class="d-flex mb-4">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="rounded-circle bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="bi bi-person text-secondary fs-4"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 p-3 bg-white rounded-4 shadow-sm">
                                        <div class="d-flex justify-content-between mb-1">
                                            <h6 class="fw-bold mb-0"><?php echo htmlspecialchars($comm['name']); ?></h6>
                                            <small class="text-muted"><?php echo date('M j, Y', strtotime($comm['created_at'])); ?></small>
                                        </div>
                                        <p class="mb-0 text-secondary"><?php echo nl2br(htmlspecialchars($comm['comment'])); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-5 mt-5">
        <p class="mb-0 small opacity-50">© 2025 PHP Blog Workshop System</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
