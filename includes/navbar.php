<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="nav flex-column">
  <a class="nav-link <?= ($current_page == 'dashboard.php') ? 'active' : '' ?>" href="dashboard.php">
    <i class="bi bi-speedometer2"></i> Dashboard
  </a>

  <?php if ($_SESSION['role'] === 'admin'): ?>
    <a class="nav-link <?= ($current_page == 'assets.php') ? 'active' : '' ?>" href="assets.php">
      <i class="bi bi-hdd-stack"></i> Assets
    </a>
  <?php endif; ?>

  <a class="nav-link <?= ($current_page == 'bookings.php') ? 'active' : '' ?>" href="bookings.php">
    <i class="bi bi-calendar-check"></i> Bookings
  </a>

  <?php if ($_SESSION['role'] === 'admin'): ?>
    <a class="nav-link <?= ($current_page == 'maintenance.php') ? 'active' : '' ?>" href="maintenance.php">
      <i class="bi bi-tools"></i> Maintenance
    </a>
  <?php endif; ?>

  <a class="nav-link <?= ($current_page == 'feedback.php') ? 'active' : '' ?>" href="feedback.php">
    <i class="bi bi-chat-left-text"></i> Feedback
  </a>
  <a class="nav-link <?= ($current_page == 'reports.php') ? 'active' : '' ?>" href="reports.php">
    <i class="bi bi-flag"></i> Reports
  </a>
  <a class="nav-link text-danger" href="logout.php">
    <i class="bi bi-box-arrow-right"></i> Logout
  </a>
</nav>
