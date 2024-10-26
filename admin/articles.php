<?php 
// /admin/articles.php
session_start();
include('../includes/config.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

// Handle form submission for Create, Edit, and Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    $id = $_POST['id'] ?? null;
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    
    // Image handling variables
    $imagePath = '';

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        
        // Make sure the upload directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
        }
        
        $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '', basename($_FILES['image']['name'])); // Sanitize filename
        $targetFilePath = $uploadDir . $imageName;

        // Allow only certain file formats
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['image']['type'], $allowedTypes)) {
            // Move uploaded file to the uploads directory
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                $imagePath = 'uploads/' . $imageName;
            } else {
                echo '<div class="alert alert-danger">Failed to upload the image. Please try again.</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Only JPG, PNG, and GIF files are allowed.</div>';
        }
    }

    // Create a new article
    if ($action === 'create' && !empty($title) && !empty($content)) {
        $query = "INSERT INTO articles (title, content, image_path, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $title, $content, $imagePath);

        if ($stmt->execute()) {
            header("Location: articles.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">Error creating article: ' . $stmt->error . '</div>';
        }
    }

    // Update an existing article
    if ($action === 'edit' && $id && !empty($title) && !empty($content)) {
        if (!empty($imagePath)) {
            // Update with new image
            $query = "UPDATE articles SET title = ?, content = ?, image_path = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssi", $title, $content, $imagePath, $id);
        } else {
            // Update without changing the image
            $query = "UPDATE articles SET title = ?, content = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssi", $title, $content, $id);
        }

        if ($stmt->execute()) {
            header("Location: articles.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">Error updating article: ' . $stmt->error . '</div>';
        }
    }

    // Delete an existing article
    if ($action === 'delete' && $id) {
        // Delete image file if it exists
        $imageQuery = "SELECT image_path FROM articles WHERE id = ?";
        $stmt = $conn->prepare($imageQuery);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($existingImagePath);
        $stmt->fetch();
        $stmt->close();
        
        if (!empty($existingImagePath) && file_exists('../' . $existingImagePath)) {
            unlink('../' . $existingImagePath); // Delete the image file
        }
        
        $query = "DELETE FROM articles WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: articles.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">Error deleting article: ' . $stmt->error . '</div>';
        }
    }
}

// Fetch all articles
$articlesQuery = "SELECT * FROM articles ORDER BY created_at DESC";
$articlesResult = $conn->query($articlesQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Articles</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
    <?php include('header.php'); ?>

    <div class="container mt-5">
        <h1>Manage Articles</h1>

        <!-- Display Create/Edit Form -->
        <div class="mb-4">
            <h2><?php echo isset($_POST['edit']) ? 'Edit Article' : 'Add New Article'; ?></h2>
            <form action="articles.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Article Title:</label>
                    <input type="text" name="title" class="form-control" value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="content">Content:</label>
                    <textarea name="content" class="form-control" rows="10" required><?php echo isset($_POST['content']) ? htmlspecialchars($_POST['content']) : ''; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Article Image:</label>
                    <input type="file" name="image" class="form-control">
                    <?php if (isset($_POST['image_path']) && !empty($_POST['image_path'])): ?>
                        <div class="mt-3">
                            <img src="../<?php echo htmlspecialchars($_POST['image_path']); ?>" alt="Article Image" style="max-width: 150px;">
                            <p>Current Image</p>
                        </div>
                    <?php endif; ?>
                </div>
                <input type="hidden" name="action" value="<?php echo isset($_POST['edit']) ? 'edit' : 'create'; ?>">
                <?php if (isset($_POST['edit'])): ?>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($_POST['id']); ?>">
                <?php endif; ?>
                <button type="submit" class="btn btn-primary"><?php echo isset($_POST['edit']) ? 'Update Article' : 'Create Article'; ?></button>
                <?php if (isset($_POST['edit'])): ?>
                    <a href="articles.php" class="btn btn-secondary">Cancel Edit</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Articles Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Published Date</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($article = $articlesResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($article['title']); ?></td>
                        <td><?php echo date('F j, Y', strtotime($article['created_at'])); ?></td>
                        <td>
                            <?php if (!empty($article['image_path'])): ?>
                                <img src="../<?php echo htmlspecialchars($article['image_path']); ?>" alt="Article Image" style="max-width: 100px;">
                            <?php endif; ?>
                        </td>
                        <td>
                            <!-- Edit Form Trigger -->
                            <form method="POST" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?php echo $article['id']; ?>">
                                <input type="hidden" name="title" value="<?php echo htmlspecialchars($article['title']); ?>">
                                <input type="hidden" name="content" value="<?php echo htmlspecialchars($article['content']); ?>">
                                <input type="hidden" name="image_path" value="<?php echo htmlspecialchars($article['image_path']); ?>">
                                <button type="submit" name="edit" class="btn btn-warning">Edit</button>
                            </form>

                            <!-- Delete Form -->
                            <form action="articles.php" method="POST" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?php echo $article['id']; ?>">
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
