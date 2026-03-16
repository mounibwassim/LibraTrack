<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $asset_id = $_GET['id'];

    // Check for related bookings to prevent FK conflict (optional)
    $check = $conn->prepare("SELECT COUNT(*) FROM bookings WHERE asset_id = ?");
    $check->bind_param("i", $asset_id);
    $check->execute();
    $check->bind_result($count);
    $check->fetch();
    $check->close();

    if ($count > 0) {
        header("Location: assets.php?error=Asset has bookings and cannot be deleted.");
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM assets WHERE id = ?");
    $stmt->bind_param("i", $asset_id);
    $stmt->execute();
}

header("Location: assets.php?msg=deleted");
exit;
?>
