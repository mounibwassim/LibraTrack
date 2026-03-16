<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include('includes/db.php');

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

$bookings_count = $conn->query("SELECT COUNT(*) AS total FROM bookings")->fetch_assoc()['total'];
$feedback_count = $conn->query("SELECT COUNT(*) AS total FROM feedbacks")->fetch_assoc()['total'];
$maintenance_count = $conn->query("SELECT COUNT(*) AS total FROM maintenance")->fetch_assoc()['total'];
$reports_count = $conn->query("SELECT COUNT(*) AS total FROM reports")->fetch_assoc()['total'];

$recent_bookings = [];
if ($role === 'student') {
    $stmt = $conn->prepare("SELECT b.id, a.name AS asset_name, b.booking_date, b.status FROM bookings b JOIN assets a ON b.asset_id = a.id WHERE b.user_id = ? ORDER BY b.created_at DESC LIMIT 5");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $recent_bookings = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LibraTrack - Dashboard</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .dashboard-icon {
            font-size: 2rem;
        }
    </style>
</head>
<body>
    <?php include('includes/layout_start.php'); ?>

    <h2 class="fw-bold mb-4"><i class="bi bi-speedometer2 me-2"></i>Dashboard (<?= ucfirst($role) ?>)</h2>

    <?php if ($role === 'admin'): ?>
    <div class="row g-4">
    <div class="col-md-3">
        <div class="card text-white bg-gradient bg-primary shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-calendar-check display-4"></i>
                <h6 class="mt-3">Bookings</h6>
                <h3 class="fw-bold"><?= $bookings_count ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-gradient bg-success shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-chat-dots display-4"></i>
                <h6 class="mt-3">Feedback</h6>
                <h3 class="fw-bold"><?= $feedback_count ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-gradient bg-warning shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-tools display-4"></i>
                <h6 class="mt-3">Maintenance</h6>
                <h3 class="fw-bold"><?= $maintenance_count ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-gradient bg-danger shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-flag display-4"></i>
                <h6 class="mt-3">Reports</h6>
                <h3 class="fw-bold"><?= $reports_count ?></h3>
            </div>
        </div>
    </div>
</div>


    <div class="mt-5">
    <h4 class="fw-semibold mb-3">Admin Shortcuts</h4>
    <div class="row g-3">
        <div class="col-md-4">
            <a href="assets.php" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-box-seam fs-2 text-primary"></i>
                        <h6 class="mt-2 mb-0 text-dark">Manage Assets</h6>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="bookings.php" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-calendar-check fs-2 text-success"></i>
                        <h6 class="mt-2 mb-0 text-dark">Review Bookings</h6>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="reports.php" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-flag fs-2 text-danger"></i>
                        <h6 class="mt-2 mb-0 text-dark">Manage Reports</h6>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="feedback.php" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-chat-dots fs-2 text-warning"></i>
                        <h6 class="mt-2 mb-0 text-dark">Review Feedback</h6>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="maintenance.php" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-wrench-adjustable-circle fs-2 text-info"></i>
                        <h6 class="mt-2 mb-0 text-dark">Manage Maintenance</h6>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

    <?php endif; ?>

    <?php if ($role === 'student'): ?>
    <div class="mt-5">
        <h4 class="fw-semibold mb-3"><i class="bi bi-clock-history me-1"></i>Recent Bookings</h4>
        <?php if (count($recent_bookings) > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Asset</th>
                        <th>Booking Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_bookings as $booking): ?>
                    <tr>
                        <td><?= $booking['id'] ?></td>
                        <td><?= htmlspecialchars($booking['asset_name']) ?></td>
                        <td><?= htmlspecialchars($booking['booking_date']) ?></td>
                        <td><?= htmlspecialchars($booking['status']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <p class="text-muted">No recent bookings found.</p>
        <?php endif; ?>
    </div>
    <?php endif; ?>

<?php include('includes/layout_end.php'); ?>
</body>
</html>