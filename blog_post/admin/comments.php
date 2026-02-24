<?php
require_once '../config/database.php';

$message = '';
$message_type = '';

// Handle actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $action = $_GET['action'];
    
    if ($action === 'approve') {
        $stmt = $pdo->prepare("UPDATE comments SET status = 'approved' WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: comments.php?msg=approved");
    } elseif ($action === 'reject') {
        $stmt = $pdo->prepare("UPDATE comments SET status = 'rejected' WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: comments.php?msg=rejected");
    } elseif ($action === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM comments WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: comments.php?msg=deleted");
    }
    exit();
}

// Flash messages
if (isset($_GET['msg'])) {
    switch ($_GET['msg']) {
        case 'approved': $message = "Comment approved!"; $message_type = "success"; break;
        case 'rejected': $message = "Comment rejected."; $message_type = "warning"; break;
        case 'deleted': $message = "Comment deleted successfully."; $message_type = "success"; break;
    }
}

// Fetch Stats
$total = $pdo->query("SELECT COUNT(*) FROM comments")->fetchColumn();
$pending = $pdo->query("SELECT COUNT(*) FROM comments WHERE status = 'pending'")->fetchColumn();
$approved = $pdo->query("SELECT COUNT(*) FROM comments WHERE status = 'approved'")->fetchColumn();
$rejected = $pdo->query("SELECT COUNT(*) FROM comments WHERE status = 'rejected'")->fetchColumn();

// Fetch Comments with Post Titles
$query = "SELECT c.*, p.title as post_title 
          FROM comments c 
          LEFT JOIN posts p ON c.post_id = p.id 
          ORDER BY c.created_at DESC";
$comments = $pdo->query($query)->fetchAll();

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pb-5">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Comments Management</h1>
    </div>

    <?php if ($message): ?>
        <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Stats Cards -->
    <div class="row row-cols-1 row-cols-md-4 g-4 mt-2 mb-4 text-center">
        <div class="col">
            <div class="card h-100 border-0 shadow-sm bg-primary text-white">
                <div class="card-body">
                    <h6 class="text-uppercase small fw-bold opacity-75">Total</h6>
                    <h2 class="mb-0"><?php echo $total; ?></h2>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 border-0 shadow-sm bg-warning text-dark">
                <div class="card-body">
                    <h6 class="text-uppercase small fw-bold opacity-75">Pending</h6>
                    <h2 class="mb-0"><?php echo $pending; ?></h2>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 border-0 shadow-sm bg-success text-white">
                <div class="card-body">
                    <h6 class="text-uppercase small fw-bold opacity-75">Approved</h6>
                    <h2 class="mb-0"><?php echo $approved; ?></h2>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 border-0 shadow-sm bg-danger text-white">
                <div class="card-body">
                    <h6 class="text-uppercase small fw-bold opacity-75">Rejected</h6>
                    <h2 class="mb-0"><?php echo $rejected; ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light text-uppercase small fw-bold">
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="py-3">User</th>
                            <th class="py-3">Comment Preview</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="py-3">Post</th>
                            <th class="py-3">Date</th>
                            <th class="px-4 py-3 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($comments)): ?>
                            <tr><td colspan="7" class="text-center py-4 text-muted">No comments found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($comments as $comm): ?>
                                <tr>
                                    <td class="px-4 py-3 text-muted"><?php echo $comm['id']; ?></td>
                                    <td class="py-3">
                                        <div class="fw-bold"><?php echo htmlspecialchars($comm['name']); ?></div>
                                        <div class="small text-muted"><?php echo htmlspecialchars($comm['email']); ?></div>
                                    </td>
                                    <td class="py-3" style="max-width: 300px;">
                                        <div class="text-truncate" title="<?php echo htmlspecialchars($comm['comment']); ?>">
                                            <?php echo htmlspecialchars($comm['comment']); ?>
                                        </div>
                                    </td>
                                    <td class="py-3 text-center">
                                        <?php if ($comm['status'] === 'approved'): ?>
                                            <span class="badge bg-success rounded-pill px-3">Approved</span>
                                        <?php elseif ($comm['status'] === 'rejected'): ?>
                                            <span class="badge bg-danger rounded-pill px-3">Rejected</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark rounded-pill px-3">Pending</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-3 small">
                                        <a href="../post.php?id=<?php echo $comm['post_id']; ?>" target="_blank" class="text-decoration-none text-primary">
                                            <?php echo htmlspecialchars($comm['post_title'] ?: 'View Post'); ?>
                                        </a>
                                    </td>
                                    <td class="py-3 small text-muted"><?php echo date('M j, Y', strtotime($comm['created_at'])); ?></td>
                                    <td class="px-4 py-3 text-end">
                                        <div class="btn-group">
                                            <?php if ($comm['status'] !== 'approved'): ?>
                                                <a href="comments.php?action=approve&id=<?php echo $comm['id']; ?>" class="btn btn-sm btn-outline-success" title="Approve"><i class="bi bi-check-lg"></i></a>
                                            <?php endif; ?>
                                            <?php if ($comm['status'] !== 'rejected'): ?>
                                                <a href="comments.php?action=reject&id=<?php echo $comm['id']; ?>" class="btn btn-sm btn-outline-warning" title="Reject"><i class="bi bi-x-lg"></i></a>
                                            <?php endif; ?>
                                            <a href="comments.php?action=delete&id=<?php echo $comm['id']; ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete this comment?')"><i class="bi bi-trash"></i></a>
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
</main>

<?php include 'includes/footer.php'; ?>
