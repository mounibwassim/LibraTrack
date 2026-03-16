<?php
session_start();
include('includes/db.php');
include('includes/layout_start.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: assets.php");
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM assets WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$asset = $result->fetch_assoc();

if (!$asset) {
    echo "<div class='alert alert-danger'>Asset not found.</div>";
    exit;
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE assets SET name = ?, category = ?, description = ?, status = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $name, $category, $description, $status, $id);
    $stmt->execute();
    header("Location: assets.php?msg=updated");
    exit;
}
?>

<div class="container mt-4">
    <h2>Edit Asset</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Asset Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($asset['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Category</label>
            <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($asset['category']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" required><?= htmlspecialchars($asset['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="Available" <?= $asset['status'] == 'Available' ? 'selected' : '' ?>>Available</option>
                <option value="In Use" <?= $asset['status'] == 'In Use' ? 'selected' : '' ?>>In Use</option>
                <option value="Under Maintenance" <?= $asset['status'] == 'Under Maintenance' ? 'selected' : '' ?>>Under Maintenance</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update Asset</button>
        <a href="assets.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include('includes/layout_end.php'); ?>
