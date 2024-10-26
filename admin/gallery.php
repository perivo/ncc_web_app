<?php
// /admin/articles.php
session_start();
include('../includes/config.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    // Handle the upload action
    if ($action === 'upload') {
        $caption = $_POST['caption'];
        $targetDir = "../assets/uploads/";
        $imageFile = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $imageFile;

        // Upload image to the server
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            // Insert image info into the database
            $query = "INSERT INTO gallery (image_path, caption, created_at) VALUES (?, ?, NOW())";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $targetFilePath, $caption);
            $stmt->execute();
            header("Location: gallery.php");
            exit;
        } else {
            $uploadError = "There was an error uploading your file.";
        }
    }

    // Handle the delete action
    if ($action === 'delete') {
        $id = $_POST['id'];

        // Fetch the image path before deleting
        $query = "SELECT image_path FROM gallery WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $image = $result->fetch_assoc();

        if ($image) {
            // Delete the file from the server
            if (file_exists($image['image_path'])) {
                unlink($image['image_path']);
            }

            // Delete the image record from the database
            $query = "DELETE FROM gallery WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            header("Location: gallery.php");
            exit;
        } else {
            $deleteError = "Image not found.";
        }
    }
}

// Fetch all gallery images
$galleryQuery = "SELECT * FROM gallery ORDER BY created_at DESC";
$galleryResult = $conn->query($galleryQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gallery</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
    <?php include('header.php'); ?>
    <div class="container mt-5">
        <h1>Manage Gallery</h1>
        
        <!-- Display Upload Error -->
        <?php if (isset($uploadError)): ?>
            <div class="alert alert-danger"><?php echo $uploadError; ?></div>
        <?php endif; ?>

        <!-- Upload Form -->
        <form action="gallery.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="image">Upload Image:</label>
                <input type="file" name="image" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="caption">Caption:</label>
                <input type="text" name="caption" class="form-control">
            </div>
            <input type="hidden" name="action" value="upload">
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>

        <hr>
        <h2>Gallery Images</h2>
        
        <!-- Display Delete Error -->
        <?php if (isset($deleteError)): ?>
            <div class="alert alert-danger"><?php echo $deleteError; ?></div>
        <?php endif; ?>

        <!-- Gallery Image List -->
        <div class="row">
            <?php while ($image = $galleryResult->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <img src="<?php echo htmlspecialchars($image['image_path']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($image['caption']); ?>">
                        <div class="card-body">
                            <p class="card-text"><?php echo htmlspecialchars($image['caption']); ?></p>
                            <form action="gallery.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $image['id']; ?>">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php include('footer.php'); ?>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
