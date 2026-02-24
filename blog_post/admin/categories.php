<?php
require_once '../config/database.php';

$message = '';
$message_type = '';

// 1. Handle POST Actions (Add & Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_category'])) {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        
        if (empty($name)) {
            $message = "Category name is required!";
            $message_type = "danger";
        } else {
            try {
                $stmt = $pdo->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
                $stmt->execute([$name, $description]);
                header("Location: categories.php?msg=added");
                exit();
            } catch (PDOException $e) {
                $message = "Error adding category: " . $e->getMessage();
                $message_type = "danger";
            }
        }
    }

    if (isset($_POST['update_category'])) {
        $id = (int)$_POST['id'];
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        
        if (empty($name)) {
            $message = "Category name is required!";
            $message_type = "danger";
        } else {
            try {
                $stmt = $pdo->prepare("UPDATE categories SET name = ?, description = ? WHERE id = ?");
                $stmt->execute([$name, $description, $id]);
                header("Location: categories.php?msg=updated");
                exit();
            } catch (PDOException $e) {
                $message = "Error updating category: " . $e->getMessage();
                $message_type = "danger";
            }
        }
    }
}

// 2. Handle GET Actions (Delete)
if (isset($_GET['del_id'])) {
    $id = (int)$_GET['del_id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: categories.php?msg=deleted");
        exit();
    } catch (PDOException $e) {
        $message = "Error deleting category: " . $e->getMessage();
        $message_type = "danger";
    }
}

// 3. Handle Flash Messages from URL
if (isset($_GET['msg'])) {
    switch ($_GET['msg']) {
        case 'added':
            $message = "Category added successfully!";
            $message_type = "success";
            break;
        case 'updated':
            $message = "Category updated successfully!";
            $message_type = "success";
            break;
        case 'deleted':
            $message = "Category deleted successfully!";
            $message_type = "success";
            break;
    }
}

// 4. Fetch Data for Display
$categories = $pdo->query("SELECT * FROM categories ORDER BY created_at DESC")->fetchAll();

// 5. Fetch Edit Item if requested
$edit_category = null;
if (isset($_GET['edit_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([(int)$_GET['edit_id']]);
    $edit_category = $stmt->fetch();
}

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pb-5">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Categories Management</h1>
    </div>

    <!-- Feedback Message -->
    <?php if ($message): ?>
        <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi <?php echo $message_type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'; ?> me-2"></i>
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row mt-4">
        <!-- Input Form (Left) -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-primary text-white py-3 rounded-top-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi <?php echo $edit_category ? 'bi-pencil-square' : 'bi-plus-circle-fill'; ?> me-2"></i>
                        <?php echo $edit_category ? 'Edit Category' : 'Add New Category'; ?>
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST">
                        <?php if ($edit_category): ?>
                            <input type="hidden" name="id" value="<?php echo $edit_category['id']; ?>">
                        <?php endif; ?>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Category Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-lg" 
                                   placeholder="e.g. Technology, News, Private..." required
                                   value="<?php echo $edit_category ? htmlspecialchars($edit_category['name']) : ''; ?>">
                            <div class="form-text small text-muted">A flexible name for your blog content.</div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" class="form-control" rows="4" 
                                      placeholder="Briefly describe this category..."><?php echo $edit_category ? htmlspecialchars($edit_category['description']) : ''; ?></textarea>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" name="<?php echo $edit_category ? 'update_category' : 'add_category'; ?>" 
                                    class="btn btn-primary py-2 fw-bold shadow-sm">
                                <i class="bi bi-save me-2"></i><?php echo $edit_category ? 'Save Changes' : 'Create Category'; ?>
                            </button>
                            
                            <?php if ($edit_category): ?>
                                <a href="categories.php" class="btn btn-outline-secondary py-2 border-0">Cancel Edit</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Categories Table (Right) -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-list-ul me-2"></i>All Categories</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-uppercase small fw-bold text-muted">
                            <tr>
                                <th class="ps-4">ID</th>
                                <th>Category Details</th>
                                <th>Created Date</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($categories)): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <i class="bi bi-folder2-open display-4 text-muted d-block mb-3"></i>
                                        <p class="text-muted">No categories found. Start by adding one!</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($categories as $cat): ?>
                                    <tr>
                                        <td class="ps-4 text-muted">#<?php echo $cat['id']; ?></td>
                                        <td>
                                            <div class="fw-bold fs-5 text-dark"><?php echo htmlspecialchars($cat['name']); ?></div>
                                            <div class="text-muted small"><?php echo htmlspecialchars($cat['description'] ?: 'No description provided.'); ?></div>
                                        </td>
                                        <td class="text-muted">
                                            <i class="bi bi-calendar3 me-2"></i><?php echo date('M d, Y', strtotime($cat['created_at'])); ?>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group shadow-sm rounded">
                                                <a href="categories.php?edit_id=<?php echo $cat['id']; ?>" 
                                                   class="btn btn-white btn-sm border-end" title="Edit Category">
                                                    <i class="bi bi-pencil-fill text-primary"></i>
                                                </a>
                                                <a href="categories.php?del_id=<?php echo $cat['id']; ?>" 
                                                   class="btn btn-white btn-sm" title="Delete Category"
                                                   onclick="return confirm('Are you sure you want to delete this category? This might affect posts linked to it.')">
                                                    <i class="bi bi-trash3-fill text-danger"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
