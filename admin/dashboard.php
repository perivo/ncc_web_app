<?php
// /admin/dashboard.php
session_start();
include('../includes/config.php');

// Check if the admin is logged in


// Fetch general stats for the dashboard
$totalArticles = $conn->query("SELECT COUNT(*) FROM articles")->fetch_row()[0];
$totalGalleryImages = $conn->query("SELECT COUNT(*) FROM gallery")->fetch_row()[0];
$totalLearningMaterials = $conn->query("SELECT COUNT(*) FROM learning_materials")->fetch_row()[0];
$totalUsers = $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0];
$totalapplicant_name = $conn->query("SELECT COUNT(*) FROM enrollments")->fetch_row()[0];
?>

<?php
include('header.php');
?>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Admin Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="card text-center mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Articles</h5>
                        <p class="card-text"><?php echo $totalArticles; ?> Articles</p>
                        <a href="articles.php" class="btn btn-primary">Manage Articles</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Gallery</h5>
                        <p class="card-text"><?php echo $totalGalleryImages; ?> Images</p>
                        <a href="gallery.php" class="btn btn-primary">Manage Gallery</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Learning Materials</h5>
                        <p class="card-text"><?php echo $totalLearningMaterials; ?> Materials</p>
                        <a href="learning.php" class="btn btn-primary">Manage Materials</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Users</h5>
                        <p class="card-text"><?php echo $totalUsers; ?> Registered Users</p>
                        <a href="users.php" class="btn btn-primary">Manage Users</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Users</h5>
                        <p class="card-text"><?php echo $totalapplicant_name; ?> Enrollment Requests</p>
                        <a href="approvals.php" class="btn btn-primary">Manage Enrollment</a>
                    </div>
                </div>
            </div>
        </div>
        <a href="../scripts/logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
<?php
include('footer.php');
?>
