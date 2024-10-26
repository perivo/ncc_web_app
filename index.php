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
    <link rel="stylesheet" href="assets/css/style.css">
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
                    <li class="nav-item"><a class="nav-link" href="public/index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="public/articles.php">Articles</a></li>
                    <li class="nav-item"><a class="nav-link" href="public/gallery.php">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link" href="public/learning.php">Learning Material</a></li>
                    <li class="nav-item"><a class="nav-link" href="public/enrollment.php">Enroll now</a></li>
                    <li class="nav-item"><a class="nav-link" href="public/contact.php">Contact Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="public/profile.php">Profile</a></li>
                    <?php if (isset($_SESSION['user_role'])): ?>
                        <?php if ($_SESSION['user_role'] === 'admin'): ?>
                            <li class="nav-item"><a class="nav-link" href="admin/dashboard.php">Admin Dashboard</a></li>
                        <?php endif; ?>
                        <li class="nav-item"><a class="nav-link" href="scripts/logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="public/login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="public/register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">


<!-- Jumbotron Section -->
<div class="jumbotron text-center bg-primary text-white py-5">
    <div class="container">
        <h1 class="display-4">Welcome to NCC Web Application</h1>
        <p class="lead">Your one-stop platform for all things related to the National Cadet Corps (NCC).</p>
        <hr class="my-4">
        <p>Learn more about NCC, explore articles, view galleries, and access resources tailored for cadets and officers.</p>
    </div>
</div>

<!-- About NCC Section -->
<section class="about-ncc py-5">
    <div class="container">
        <h2 class="text-center mb-4">What is NCC?</h2>
        <div class="row">
            <div class="col-md-6">
                <img src="assets/images/ncc-banner.jpg" class="img-fluid rounded shadow-lg mb-4" alt="NCC Banner">
            </div>
            <div class="col-md-6">
                <p>
                    The National Cadet Corps (NCC) is a youth development movement in India. It aims to develop qualities of character, courage, leadership, discipline, and a spirit of adventure among young citizens.
                </p>
                <p>
                    The NCC also instills in cadets the values of patriotism, selfless service, and contributes to the national cause. With a focus on both academic and extracurricular growth, the NCC helps shape the youth of today into responsible citizens of tomorrow.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- About Web App Section -->
<section class="about-webapp bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-4">About This Web Application</h2>
        <div class="row">
            <div class="col-md-4 text-center">
                <div class="card p-3 mb-4 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">NCC Articles</h5>
                        <p class="card-text">Read the latest articles on NCC activities, events, and updates from cadets and officers.</p>
                        <a href="public/articles.php" class="btn btn-primary">Explore Articles</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="card p-3 mb-4 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Gallery</h5>
                        <p class="card-text">View a curated gallery of NCC photos, highlighting the achievements, events, and life of cadets.</p>
                        <a href="public/gallery.php" class="btn btn-primary">View Gallery</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="card p-3 mb-4 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Resources</h5>
                        <p class="card-text">Access study materials, documents, and other resources tailored for NCC cadets and officers.</p>
                        <a href="public/learning.php" class="btn btn-primary">Access Resources</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sign Up and Login Section -->
<section class="login-signup py-5">
    <div class="container text-center">
        <h2 class="mb-4">Get Started</h2>
        <div class="row justify-content-center">
            <div class="col-md-5 mb-3">
                <div class="card p-4 shadow-sm border-0">
                    <h5>User Access</h5>
                    <a href="public/register.php" class="btn btn-success mt-2 mb-2 w-100">User Sign Up</a>
                    <a href="public/login.php" class="btn btn-secondary w-100">User Login</a>
                </div>
            </div>
            <div class="col-md-5 mb-3">
                <div class="card p-4 shadow-sm border-0">
                    <h5>Admin Access</h5>
                    <a href="admin/signup.php" class="btn btn-danger mt-2 mb-2 w-100">Admin Sign Up</a>
                    <a href="admin/index.php" class="btn btn-dark w-100">Admin Login</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>

<!-- Custom Styles -->
<style>
    .jumbotron {
        background-image: url('assets/images/ncc-background.jpg');
        background-size: cover;
        background-position: center;
        color: white;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);
    }
    .about-ncc p {
        font-size: 1.1rem;
        line-height: 1.6;
    }
    .card {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
    }
</style>
