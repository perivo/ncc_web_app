<?php
// /public/edit_profile.php
include('../includes/header.php');
include('../includes/config.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Ensure session is started
}

// Check if user is logged in
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

// Set default values to avoid undefined index warnings
$name = htmlspecialchars($user['name']);
$email = htmlspecialchars($user['email']);
$age = isset($user['age']) ? htmlspecialchars($user['age']) : '';
$phone = isset($user['phone']) ? htmlspecialchars($user['phone']) : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    $profile_pic = $_FILES['profile_pic'];


    
        // Handle profile picture upload
        $uploadDir = '../uploads/';
        $uploadFile = $uploadDir . basename($profile_pic['name']);
        
        if (move_uploaded_file($profile_pic['tmp_name'], $uploadFile)) {
            // Update user data
            $updateQuery = "UPDATE users SET name = ?, email = ?, age = ?, phone = ?, profile_pic = ? WHERE id = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("ssissi", $name, $email, $age, $phone, $profile_pic['name'], $user_id);
    
            if ($stmt->execute()) {
                echo '<p class="alert alert-success">Profile updated successfully.</p>';
            } else {
                echo '<p class="alert alert-danger">Error updating profile. Please try again.</p>';
            }
        } else {
            echo '<p class="alert alert-danger">Error uploading profile picture. Please try again.</p>';
        }
        
        $stmt->close();
        header("Refresh:0"); // Refresh the page to show the updated data
    }
    
?>

<div class="container mt-5">
    <h2>Edit Profile</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
        </div>
        <div class="form-group">
            <label for="age">Age</label>
            <input type="number" class="form-control" id="age" name="age" value="<?php echo $age; ?>" required min="10" max="100">
        </div>
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>" required>
        </div>
        <div class="form-group">
            <label for="profile_pic">Profile Picture</label>
            <input type="file" class="form-control" id="profile_pic" name="profile_pic">
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>

<?php 
$stmt->close();
include('../includes/footer.php'); 
?>
