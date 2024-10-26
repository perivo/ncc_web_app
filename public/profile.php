<?php
// /public/profile.php
include('../includes/header.php');
include('../includes/config.php');

// Ensure session is started only if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start(); 
}

// Assuming user ID is stored in session after login
if (!isset($_SESSION['user_id'])) {
    echo '<p class="alert alert-danger">User not logged in.</p>';
    exit;
}

$user_id = $_SESSION['user_id']; // Get user ID from session

// Fetch user information from the database
$userQuery = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($userQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$userResult = $stmt->get_result();

if ($userResult->num_rows > 0) {
    $user = $userResult->fetch_assoc();
} else {
    echo '<p class="alert alert-danger">User not found.</p>';
    exit;
}

// Fetch enrollment status
$enrollmentQuery = "SELECT * FROM enrollments WHERE id = ?"; // Ensure this column exists in the table
$enrollmentStmt = $conn->prepare($enrollmentQuery);
$enrollmentStmt->bind_param("i", $user_id);
$enrollmentStmt->execute();
$enrollmentResult = $enrollmentStmt->get_result();
?>

<div class="container mt-5">
    <h2>User Profile</h2>
    <div class="row">
        <div class="col-md-4">
            <img src="../uploads/<?php echo htmlspecialchars($user['profile_pic']); ?>" alt="Profile Picture" class="img-fluid rounded-circle">
            <h3><?php echo htmlspecialchars($user['name']); ?></h3>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
            <p>Age: <?php echo isset($user['age']) ? htmlspecialchars($user['age']) : 'N/A'; ?></p>
            <p>Phone: <?php echo isset($user['phone']) ? htmlspecialchars($user['phone']) : 'N/A'; ?></p>
            <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
        </div>
        <div class="col-md-8">
            <h4>Enrollment Status</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Status</th>
                        <th>Submitted Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($enrollmentResult->num_rows > 0): ?>
                        <?php while ($enrollment = $enrollmentResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($enrollment['unit']); ?></td>
                                <td><?php echo htmlspecialchars($enrollment['status']); ?></td>
                                <td><?php echo date('F j, Y', strtotime($enrollment['submitted_at'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">No enrollments found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
$stmt->close();
$enrollmentStmt->close();
include('../includes/footer.php'); 
?>
