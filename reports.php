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

// Add report (Student only)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add']) && $role === 'student') {
    $asset_id = $_POST['asset_id'];
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (!empty($title) && !empty($content)) {
        $stmt = $conn->prepare("INSERT INTO reports (user_id, asset_id, title, content) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $user_id, $asset_id, $title, $content);
        $stmt->execute();
    }
}

// Update status (Admin only)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update']) && $isAdmin) {
    $id = $_POST['report_id'];
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE reports SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
}

// Delete report (Admin only)
if (isset($_GET['delete']) && $isAdmin) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM reports WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Fetch reports with asset and user info
$query = $isAdmin ?
    "SELECT r.*, a.name AS asset_name, u.username FROM reports r LEFT JOIN assets a ON r.asset_id = a.id JOIN users u ON r.user_id = u.id ORDER BY r.created_at DESC" :
    "SELECT r.*, a.name AS asset_name, u.username FROM reports r LEFT JOIN assets a ON r.asset_id = a.id JOIN users u ON r.user_id = u.id WHERE r.user_id = $user_id ORDER BY r.created_at DESC";
$reports = $conn->query($query);

// Fetch assets
$assets = $conn->query("SELECT id, name FROM assets");
?>

<div class="container py-4">
    <h2 class="mb-4 fw-bold text-primary"><i class="bi bi-flag me-2"></i>Reports</h2>

    <?php if ($role === 'student'): ?>
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <strong><i class="bi bi-plus-circle me-1"></i>Submit Report</strong>
        </div>
        <div class="card-body">
            <form method="POST">
                <input type="hidden" name="add" value="1">
                <div class="form-floating mb-3">
                    <select name="asset_id" class="form-select" id="reportAsset" required>
                        <option value="" disabled selected>Select Asset</option>
                        <?php while($asset = $assets->fetch_assoc()): ?>
                            <option value="<?= $asset['id'] ?>"><?= htmlspecialchars($asset['name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                    <label for="reportAsset">Asset</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="title" class="form-control" id="reportTitle" placeholder="Title" required>
                    <label for="reportTitle">Title</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea name="content" class="form-control" id="reportContent" placeholder="Content" required></textarea>
                    <label for="reportContent">Content</label>
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
                    <th>Asset</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Status</th>
                    <th>Created</th>
                    <?php if ($isAdmin): ?><th>Action</th><?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $reports->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['asset_name'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['content']) ?></td>
                    <td>
                        <?php if ($isAdmin): ?>
                        <form method="POST" class="d-flex align-items-center">
                            <input type="hidden" name="update" value="1">
                            <input type="hidden" name="report_id" value="<?= $row['id'] ?>">
                            <select name="status" class="form-select me-2">
                                <option value="Unread" <?= $row['status'] == 'Unread' ? 'selected' : '' ?>>Unread</option>
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
                        <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this report?')">
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
