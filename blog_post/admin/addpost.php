<?php
require_once '../config/database.php';

$message = '';
$message_type = '';

// Fetch categories for dropdown
$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category_id = (int)$_POST['category_id'];
    $status = $_POST['status'];
    
    if (empty($title) || empty($content) || empty($category_id)) {
        $message = "Please fill in all required fields.";
        $message_type = "danger";
    } else {
        // Handle Image Upload
        $imageName = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $imageName = time() . '_' . uniqid() . '.' . $ext;
            
            if (!is_dir('../uploads')) {
                mkdir('../uploads', 0777, true);
            }
            
            move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $imageName);
        }
        
        $stmt = $pdo->prepare("INSERT INTO posts (title, content, category_id, status, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $content, $category_id, $status, $imageName]);
        
        header("Location: posts.php?msg=added");
        exit();
    }
}

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pb-5">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add New Post</h1>
        <a href="posts.php" class="btn btn-outline-secondary btn-sm">Back to Posts</a>
    </div>

    <?php if ($message): ?>
        <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body p-4">
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Post Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control form-control-lg" placeholder="Enter post title" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Content <span class="text-danger">*</span></label>
                            <textarea name="content" class="form-control" rows="15" placeholder="Write your post content here..." required></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light border-0 p-3 mb-4">
                            <h6 class="fw-bold mb-3">Publishing Options</h6>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Category <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select" required>
                                    <?php if (empty($categories)): ?>
                                        <option value="">No categories found - Add one first!</option>
                                    <?php else: ?>
                                        <option value="">-- Choose Category --</option>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?php echo $cat['id']; ?>">
                                                <?php echo htmlspecialchars($cat['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Status</label>
                                <select name="status" class="form-select">
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Featured Image</label>
                                <input type="file" name="image" class="form-control">
                                <div class="form-text small">Recommended size: 1200x800px</div>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Publish Post</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
