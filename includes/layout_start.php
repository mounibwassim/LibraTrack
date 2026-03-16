<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LibraTrack</title>
  <link rel="icon" type="image/x-icon" href="favicon.ico">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8f9fa;
    }
    .top-header {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
      background: linear-gradient(90deg, #0069d9, #0056b3);
      color: white;
      padding: 1.5rem;
      font-size: 1.75rem;
      font-weight: 600;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    .sidebar {
      background-color: #ffffff;
      border-right: 1px solid #dee2e6;
      padding: 1.5rem 0;
      height: 100vh;
      box-shadow: inset -1px 0 0 rgba(0,0,0,0.1);
    }
    .sidebar .nav-link {
      color: #333;
      font-weight: 500;
      padding: 0.75rem 1.25rem;
      display: flex;
      align-items: center;
    }
    .sidebar .nav-link.active {
      background-color: #0d6efd;
      color: #fff !important;
      border-radius: 0.375rem;
    }
    .sidebar .nav-link:hover {
      background-color: #e9ecef;
      border-radius: 0.375rem;
    }
    .sidebar .bi {
      margin-right: 0.5rem;
    }
    .content {
      padding: 2rem;
    }
    .card {
      border: none;
      border-radius: 0.75rem;
      box-shadow: 0 0.75rem 1.25rem rgba(0, 0, 0, 0.05);
    }
  </style>
</head>
<body>
  <div class="top-header d-flex justify-content-center align-items-center gap-2">
    <img src="favicon.ico" alt="Logo" width="32" height="32" style="object-fit: contain;">
    <span>LibraTrack</span>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2 sidebar">
        <?php include('navbar.php'); ?>
      </div>
      <div class="col-md-10 content">
