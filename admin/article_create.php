<?php
// /admin/dashboard.php
session_start();
include('../includes/config.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

// Handle form submission to create a new article
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Check if the fields are not empty
    if (!empty($title) && !empty($content)) {
        // Insert the new article into the database
        $query = "INSERT INTO articles (title, content, created_at) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $title, $content);
        
        if ($stmt->execute()) {
            // Redirect to articles page after successful insert
            header("Location: articles.php");
            exit;
        } else {
            $error = "Error while creating the article.";
        }
    } else {
        $error = "Title and content cannot be empty.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Article</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
    <?php include('header.php'); ?>
    
    <div class="container mt-5">
        <h1>Create New Article</h1>
        
        <!-- Display error if any -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Article Creation Form -->
        <form action="article_create.php" method="POST">
            <div class="form-group">
                <label for="title">Article Title:</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea name="content" class="form-control" rows="10" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Article</button>
            <a href="articles.php" class="btn btn-secondary">Back to Articles</a>
        </form>
    </div>

    <?php include('footer.php'); ?>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
