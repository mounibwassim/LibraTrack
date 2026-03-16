<?php
session_start();
include('includes/db.php');
include('includes/layout_start.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$isAdmin = ($_SESSION['role'] === 'admin');
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

// Handle Add (Admin only)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add']) && $isAdmin) {
    $asset_id = $_POST['asset_id'];
    $issue_description = $_POST['issue_description'];

    $stmt = $conn->prepare("INSERT INTO maintenance (asset_id, issue_description, reported_by) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $asset_id, $issue_description, $user_id);
    $stmt->execute();
}

// Handle Delete (Admin only)
if (isset($_GET['delete']) && $isAdmin) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM maintenance WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Handle Status Update (Admin only)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update']) && $isAdmin) {
    $id = $_POST['maintenance_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE maintenance SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
}

// Fetch maintenance records with user and asset info
$query = "SELECT m.*, a.name AS asset_name, u.username AS reported_by_username, a.id AS asset_id
          FROM maintenance m
          JOIN assets a ON m.asset_id = a.id
          JOIN users u ON m.reported_by = u.id
          ORDER BY m.created_at DESC";
$maintenances = $conn->query($query);

// Fetch assets list
$assets = $conn->query("SELECT id, name FROM assets");
?>

<div class="container py-4">
    <h2 class="mb-4 fw-bold text-primary"><i class="bi bi-tools me-2"></i>Maintenance Records</h2>

    <?php if ($isAdmin): ?>
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <strong><i class="bi bi-plus-circle me-1"></i>New Maintenance Record</strong>
        </div>
        <div class="card-body">
            <form method="POST">
                <input type="hidden" name="add" value="1">
                <div class="form-floating mb-3">
                    <select name="asset_id" class="form-select" required id="assetSelect">
                        <option value="" disabled selected>Select Asset</option>
                        <?php while($row = $assets->fetch_assoc()): ?>
                            <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                    <label for="assetSelect">Asset</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea name="issue_description" class="form-control" id="issue" placeholder="Describe the issue" required></textarea>
                    <label for="issue">Issue Description</label>
                </div>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Add Maintenance</button>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Asset ID</th>
                    <th>Asset Name</th>
                    <th>Issue</th>
                    <th>Reported By</th>
                    <th>Status</th>
                    <th>Created</th>
                    <?php if ($isAdmin): ?><th>Action</th><?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $maintenances->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['asset_id']) ?></td>
                    <td><?= htmlspecialchars($row['asset_name']) ?></td>
                    <td><?= htmlspecialchars($row['issue_description']) ?></td>
                    <td><?= htmlspecialchars($row['reported_by_username']) ?></td>
                    <td>
                        <?php if ($isAdmin): ?>
                        <form method="POST" class="d-flex align-items-center">
                            <input type="hidden" name="update" value="1">
                            <input type="hidden" name="maintenance_id" value="<?= $row['id'] ?>">
                            <select name="status" class="form-select me-2">
                                <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="In Progress" <?= $row['status'] == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                                <option value="Completed" <?= $row['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
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
                        <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this maintenance record?')">
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
