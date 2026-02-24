<?php
require_once '../config/database.php';

$message = '';
$message_type = '';

// Handle Delete Post
if (isset($_GET['del_id'])) {
    $id = (int)$_GET['del_id'];
    
    // Get image to delete from file system
    $stmt = $pdo->prepare("SELECT image FROM posts WHERE id = ?");
    $stmt->execute([$id]);
    $postImg = $stmt->fetchColumn();
    
    if ($postImg && file_exists('../uploads/' . $postImg)) {
        unlink('../uploads/' . $postImg);
    }
    
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: posts.php?msg=deleted");
    exit();
}

// Flash messages
if (isset($_GET['msg'])) {
    switch ($_GET['msg']) {
        case 'added': $message = "Post created successfully!"; $message_type = "success"; break;
        case 'updated': $message = "Post updated successfully!"; $message_type = "success"; break;
        case 'deleted': $message = "Post deleted successfully!"; $message_type = "success"; break;
    }
}

// Fetch posts with category names
$query = "SELECT p.*, c.name as category_name 
          FROM posts p 
          LEFT JOIN categories c ON p.category_id = c.id 
          ORDER BY p.created_at DESC";
$posts = $pdo->query($query)->fetchAll();

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pb-5">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Posts Management</h1>
        <a href="addpost.php" class="btn btn-primary d-flex align-items-center">
            <i class="bi bi-plus-circle me-2"></i>Add New Post
        </a>
    </div>

    <?php if ($message): ?>
        <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="py-3">Title</th>
                            <th class="py-3">Category</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Views</th>
                            <th class="py-3">Created At</th>
                            <th class="px-4 py-3 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($posts)): ?>
                            <tr><td colspan="7" class="text-center py-4 text-muted">No posts found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($posts as $post): ?>
                                <tr>
                                    <td class="px-4 py-3"><?php echo $post['id']; ?></td>
                                    <td class="py-3">
                                        <div class="fw-bold"><?php echo htmlspecialchars($post['title']); ?></div>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-light text-dark border"><?php echo htmlspecialchars($post['category_name'] ?: 'Uncategorized'); ?></span>
                                    </td>
                                    <td class="py-3">
                                        <?php if ($post['status'] === 'published'): ?>
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">Published</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25">Draft</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-3 text-muted"><?php echo $post['views']; ?></td>
                                    <td class="py-3 small text-muted"><?php echo date('M j, Y', strtotime($post['created_at'])); ?></td>
                                    <td class="px-4 py-3 text-end">
                                        <a href="editpost.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                                        <a href="posts.php?del_id=<?php echo $post['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this post?')"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
