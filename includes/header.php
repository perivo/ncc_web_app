<?php
// header.php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NCC Web Application</title>
    <!-- Online Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Optional custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Online jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- Online Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <!-- Navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/public/index.php">NCC Web App</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="../public/index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="../public/articles.php">Articles</a></li>
                    <li class="nav-item"><a class="nav-link" href="../public/gallery.php">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link" href="../public/learning.php">Learning Material</a></li>
                    <li class="nav-item"><a class="nav-link" href="../public/enrollment.php">Enroll now</a></li>
                    <li class="nav-item"><a class="nav-link" href="../public/contact.php">Contact Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="../public/profile.php">Profile</a></li>
                    <?php if (isset($_SESSION['user_role'])): ?>
                        <?php if ($_SESSION['user_role'] === 'admin'): ?>
                            <li class="nav-item"><a class="nav-link" href="../admin/dashboard.php">Admin Dashboard</a></li>
                        <?php endif; ?>
                        <li class="nav-item"><a class="nav-link" href="../scripts/logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="../public/login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="../public/register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
