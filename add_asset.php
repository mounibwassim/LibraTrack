<?php
session_start();
include('includes/db.php');
include('includes/layout_start.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $status = $_POST['status'];

    $image_path = null;
    if (isset($_FILES['asset_image']) && $_FILES['asset_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/assets/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $file_tmp = $_FILES['asset_image']['tmp_name'];
        $file_name = time() . '_' . basename($_FILES['asset_image']['name']);
        $target_path = $upload_dir . $file_name;

        if (move_uploaded_file($file_tmp, $target_path)) {
            $image_path = $target_path;
        }
    }

    if (!empty($name) && !empty($category) && !empty($description)) {
        $stmt = $conn->prepare("INSERT INTO assets (name, category, description, status, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $category, $description, $status, $image_path);
        if ($stmt->execute()) {
            header("Location: assets.php?msg=added");
            exit;
        } else {
            $error = "Failed to add asset.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<div class="container mt-4">
    <h2 class="mb-4"><i class="bi bi-hdd-stack me-2"></i>Add New Asset</h2>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Asset Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Category</label>
            <input type="text" name="category" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="Available">Available</option>
                <option value="In Use">In Use</option>
                <option value="Under Maintenance">Under Maintenance</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Upload Asset Image</label>
            <input type="file" name="asset_image" accept="image/*" class="form-control" onchange="previewImage(this)">
            <small class="text-muted">Recommended size: 150x150px</small>
            <div class="mt-2">
                <img id="preview" class="preview-img d-none" alt="Preview" style="width:150px; height:150px; object-fit:cover; border:1px solid #ccc; border-radius:0.5rem;">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Add Asset</button>
        <a href="assets.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    const file = input.files[0];
    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('d-none');
    }
}
</script>

<?php include('includes/layout_end.php'); ?>
