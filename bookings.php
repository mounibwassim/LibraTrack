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

// Handle Add Booking (Student only)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit_booking']) && $role === 'student') {
    $asset_id = $_POST['asset_id'];
    $booking_date = $_POST['booking_date'];

    $stmt = $conn->prepare("INSERT INTO bookings (user_id, asset_id, booking_date) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $user_id, $asset_id, $booking_date);
    $stmt->execute();
    $success = "Booking submitted!";
}

// Handle category filter
$filter = "";
$categoryTitle = "";
if (!empty($_GET['category'])) {
    $selectedCategory = $conn->real_escape_string($_GET['category']);
    $filter = " AND category = '$selectedCategory'";
    $categoryTitle = " – " . htmlspecialchars($selectedCategory);
}

// Fetch Assets for Student Booking
$assets = $conn->query("SELECT * FROM assets WHERE status = 'Available' $filter ORDER BY created_at DESC");

// Fetch Bookings (for admin list view)
$bookings = $conn->query("
    SELECT b.id, u.username, a.name AS asset_name, b.booking_date, b.status, b.created_at
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    JOIN assets a ON b.asset_id = a.id
    ORDER BY b.created_at DESC
");
?>

<div class="container mt-4">
    <h2 class="mb-4">Bookings<?= $categoryTitle ?></h2>

    <?php if ($role === 'student'): ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $success ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

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
                    <a href="bookings.php" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </div>
        </form>

        <!-- Asset Cards -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php while ($asset = $assets->fetch_assoc()): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <?php if (!empty($asset['image_path']) && file_exists($asset['image_path'])): ?>
        <div class="ratio ratio-4x3">
            <img src="<?= $asset['image_path'] ?>" class="img-fluid rounded-top" style="object-fit: contain;" alt="Asset Image">
        </div>
        <?php else: ?>
            <div class="text-center py-5 text-muted">No Image</div>
        <?php endif; ?>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($asset['name']) ?></h5>
                            <p class="card-text small mb-1"><?= htmlspecialchars($asset['description']) ?></p>
                            <p class="text-muted"><small>Category: <?= htmlspecialchars($asset['category']) ?></small></p>
                            <form method="POST" class="mt-auto">
                                <input type="hidden" name="asset_id" value="<?= $asset['id'] ?>">
                                <div class="mb-2">
                                    <label class="form-label">Booking Date</label>
                                    <input type="date" name="booking_date" class="form-control" required>
                                </div>
                                <button type="submit" name="submit_booking" class="btn btn-primary w-100">
                                    <i class="bi bi-calendar-plus"></i> Book Now
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>

    <?php
// Handle admin actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isAdmin) {
    if (isset($_POST['update_status'])) {
        $bookingId = $_POST['booking_id'];
        $newStatus = $_POST['status'];
        $stmt = $conn->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $newStatus, $bookingId);
        $stmt->execute();
    }

    if (isset($_POST['delete_booking'])) {
        $bookingId = $_POST['booking_id'];
        $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
        $stmt->bind_param("i", $bookingId);
        $stmt->execute();
    }
}

// Refresh bookings after any update/delete
$bookings = $conn->query("
    SELECT b.id, u.username, a.name AS asset_name, b.booking_date, b.status, b.created_at
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    JOIN assets a ON b.asset_id = a.id
    ORDER BY b.created_at DESC
");
?>

<?php if ($isAdmin): ?>
    <h4 class="mt-5 mb-3">Manage Bookings</h4>
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Asset</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $bookings->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['asset_name']) ?></td>
                        <td><?= htmlspecialchars($row['booking_date']) ?></td>
                        <td>
                            <form method="POST" class="d-flex align-items-center">
                                <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                                <select name="status" class="form-select form-select-sm me-2">
                                    <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="Approved" <?= $row['status'] == 'Approved' ? 'selected' : '' ?>>Approved</option>
                                    <option value="Rejected" <?= $row['status'] == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                                </select>
                                <button type="submit" name="update_status" class="btn btn-success btn-sm me-1">
                                    <i class="bi bi-check-circle"></i>
                                </button>
                            </form>
                        </td>
                        <td><?= $row['created_at'] ?></td>
                        <td>
                            <form method="POST" onsubmit="return confirm('Are you sure you want to delete this booking?');">
                                <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                                <button type="submit" name="delete_booking" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

</div>

<?php include('includes/layout_end.php'); ?>
