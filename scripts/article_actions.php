<?php
// /scripts/article_actions.php
include('../includes/config.php');
session_start();
include('../includes/auth.php');

// Ensure only admins can perform article operations
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    // Create or update an article
    if ($action === 'create' || $action === 'update') {
        $title = $_POST['title'];
        $content = $_POST['content'];

        if ($action === 'create') {
            // Create new article
            $query = "INSERT INTO articles (title, content, created_at) VALUES (?, ?, NOW())";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $title, $content);
            $stmt->execute();
        } elseif ($action === 'update' && isset($_POST['id'])) {
            // Update existing article
            $id = intval($_POST['id']);
            $query = "UPDATE articles SET title = ?, content = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssi", $title, $content, $id);
            $stmt->execute();
        }

    // Delete an article
    } elseif ($action === 'delete' && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $query = "DELETE FROM articles WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
    
    header('Location: /admin/articles.php');
    exit();
}
?>
