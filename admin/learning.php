<?php
// /admin/learning.php
session_start();
include('../includes/config.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

// Handle file upload and deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    $title = $_POST['title'] ?? '';
    $filePath = '';

    // Handle file upload
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK && empty($action)) {
        $uploadDir = '../uploads/learning_materials/';

        // Make sure the upload directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
        }

        $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '', basename($_FILES['file']['name'])); // Sanitize filename
        $targetFilePath = $uploadDir . $fileName;

        // Allow only certain file formats
        $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        if (in_array($_FILES['file']['type'], $allowedTypes)) {
            // Move uploaded file to the uploads directory
            if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
                $filePath = 'uploads/learning_materials/' . $fileName;

                // Insert file data into the database
                $query = "INSERT INTO learning_materials (title, file_path, uploaded_at) VALUES (?, ?, NOW())";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ss", $title, $filePath);

                if ($stmt->execute()) {
                    header("Location: learning.php");
                    exit;
                } else {
                    echo '<div class="alert alert-danger">Error uploading learning material: ' . $stmt->error . '</div>';
                }
            } else {
                echo '<div class="alert alert-danger">Failed to upload the file. Please try again.</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Only PDF and DOC files are allowed.</div>';
        }
    }

    // Handle file deletion
    if ($action === 'delete' && isset($_POST['id'])) {
        $id = $_POST['id'];

        // Fetch file path to delete
        $query = "SELECT file_path FROM learning_materials WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($existingFilePath);
        $stmt->fetch();
        $stmt->close();

        // Delete file from the server
        if (!empty($existingFilePath) && file_exists('../' . $existingFilePath)) {
            unlink('../' . $existingFilePath); // Delete the file
        }

        // Delete from the database
        $query = "DELETE FROM learning_materials WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: learning.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">Error deleting learning material: ' . $stmt->error . '</div>';
        }
    }
}

// Fetch all learning materials
$learningQuery = "SELECT * FROM learning_materials ORDER BY uploaded_at DESC";
$learningResult = $conn->query($learningQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Learning Material</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
    <?php include('header.php'); ?>
    <div class="container mt-5">
        <h1>Manage Learning Material</h1>
        <form action="learning.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="file">Upload Learning Material (PDF/DOC):</label>
                <input type="file" name="file" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>

        <hr>
        <h2>Uploaded Materials</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>File</th>
                    <th>Uploaded Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($material = $learningResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($material['title']); ?></td>
                        <td><a href="../<?php echo htmlspecialchars($material['file_path']); ?>" target="_blank">View</a></td>
                        <td><?php echo date('F j, Y', strtotime($material['uploaded_at'])); ?></td>
                        <td>
                            <form action="learning.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $material['id']; ?>">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php include('footer.php'); ?>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
