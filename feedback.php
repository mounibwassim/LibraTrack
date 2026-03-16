<?php
session_start();
include('includes/db.php');
include('includes/layout_start.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
$isAdmin = ($role === 'admin');

// Add feedback (Student only)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add']) && $role === 'student') {
    $title = trim($_POST['title']);
    $message = trim($_POST['message']);
    if (!empty($title) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO feedbacks (user_id, title, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $title, $message);
        $stmt->execute();
    }
}

// Update status (Admin only)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update']) && $isAdmin) {
    $id = intval($_POST['feedback_id']);
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE feedbacks SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
}

// Delete feedback (Admin only)
if (isset($_GET['delete']) && $isAdmin) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM feedbacks WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Fetch feedbacks
$query = $isAdmin ?
    "SELECT f.*, u.username FROM feedbacks f JOIN users u ON f.user_id = u.id ORDER BY f.created_at DESC" :
    "SELECT f.*, u.username FROM feedbacks f JOIN users u ON f.user_id = u.id WHERE f.user_id = $user_id ORDER BY f.created_at DESC";
$feedbacks = $conn->query($query);
?>

<div class="container py-4">
    <h2 class="mb-4 fw-bold text-primary"><i class="bi bi-chat-left-text me-2"></i>Feedback</h2>

    <?php if ($role === 'student'): ?>
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <strong><i class="bi bi-plus-circle me-1"></i>Submit Feedback</strong>
        </div>
        <div class="card-body">
            <form method="POST">
                <input type="hidden" name="add" value="1">
                <div class="form-floating mb-3">
                    <input type="text" name="title" class="form-control" id="feedbackTitle" placeholder="Title" required>
                    <label for="feedbackTitle">Title</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea name="message" class="form-control" id="feedbackMessage" placeholder="Your message" required></textarea>
                    <label for="feedbackMessage">Message</label>
                </div>
                <button type="submit" class="btn btn-primary"><i class="bi bi-send me-1"></i>Submit</button>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Title</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Created</th>
                    <?php if ($isAdmin): ?><th>Action</th><?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $feedbacks->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['message']) ?></td>
                    <td>
                        <?php if ($isAdmin): ?>
                        <form method="POST" class="d-flex align-items-center">
                            <input type="hidden" name="update" value="1">
                            <input type="hidden" name="feedback_id" value="<?= $row['id'] ?>">
                            <select name="status" class="form-select me-2">
                                <option value="Submitted" <?= $row['status'] == 'Submitted' ? 'selected' : '' ?>>Submitted</option>
                                <option value="In Progress" <?= $row['status'] == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                                <option value="Reviewed" <?= $row['status'] == 'Reviewed' ? 'selected' : '' ?>>Reviewed</option>
                            </select>
                            <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-check-circle"></i></button>
                        </form>
                        <?php else: ?>
                            <?= htmlspecialchars($row['status']) ?>
                        <?php endif; ?>
                    </td>
                    <td><?= $row['created_at'] ?></td>
                    <?php if ($isAdmin): ?>
                    <td>
                        <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this feedback?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('includes/layout_end.php'); ?>
