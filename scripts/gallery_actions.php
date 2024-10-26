<?php
// /scripts/gallery_actions.php
include('../includes/config.php');
session_start();
include('../includes/auth.php');

// Ensure only admins can perform gallery operations
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    // Upload a new gallery image
    if ($action === 'upload' && isset($_FILES['image'])) {
        $uploadDir = '../uploads/gallery/';
        $fileName = basename($_FILES['image']['name']);
        $targetFilePath = $uploadDir . $fileName;

        $caption = $_POST['caption'];

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            // Insert image details into the database
            $query = "INSERT INTO gallery (image_path, caption, created_at) VALUES (?, ?, NOW())";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $targetFilePath, $caption);
            $stmt->execute();
        }

    // Delete a gallery image
    } elseif ($action === 'delete' && isset($_POST['id'])) {
        $id = intval($_POST['id']);

        // Get the image path to delete the file
        $query = "SELECT image_path FROM gallery WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $image = $result->fetch_assoc();

        if ($image) {
            // Delete the file
            unlink($image['image_path']);

            // Remove image record from the database
            $deleteQuery = "DELETE FROM gallery WHERE id = ?";
            $deleteStmt = $conn->prepare($deleteQuery);
            $deleteStmt->bind_param("i", $id);
            $deleteStmt->execute();
        }
    }
    
    header('Location: /admin/gallery.php');
    exit();
}
?>
