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

// Handle category filter
$filter = "";
$categoryTitle = "";
if (!empty($_GET['category'])) {
    $selectedCategory = $conn->real_escape_string($_GET['category']);
    $filter = " AND category = '$selectedCategory'";
    $categoryTitle = " – " . htmlspecialchars($selectedCategory);
}

// Fetch assets
$result = $conn->query("SELECT * FROM assets WHERE 1 $filter ORDER BY created_at DESC");
?>

<div class="container mt-4">
    <h2 class="mb-4">Assets</h2>

        <!-- Filter Form -->
        <form method="GET" class="mb-4">
            <div class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Filter by Category</label>
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        <?php
                        $categories = $conn->query("SELECT DISTINCT category FROM assets WHERE status = 'Available'");
                        while ($cat = $categories->fetch_assoc()):
                            $selected = (isset($_GET['category']) && $_GET['category'] === $cat['category']) ? 'selected' : '';
                        ?>
                            <option value="<?= $cat['category'] ?>" <?= $selected ?>><?= $cat['category'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
                </div>
                <div class="col-md-2">
                    <a href="assets.php" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </div>
        </form>

    <?php if ($isAdmin): ?>
    <a href="add_asset.php" class="btn btn-primary mb-3">Add New Asset</a>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <?php if ($isAdmin): ?><th>Actions</th><?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>
                        <?php if (!empty($row['image_path']) && file_exists($row['image_path'])): ?>
                            <img src="<?= $row['image_path'] ?>" class="img-thumbnail" style="width: 550px; height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <span class="text-muted">No Image</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <?php if ($isAdmin): ?>
                    <td>
                        <a href="edit_asset.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_asset.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this asset?')">Delete</a>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('includes/layout_end.php'); ?>
