<?php
// /admin/signup.php
include('../includes/config.php');

// Handle signup form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if the username already exists
    $query = "SELECT * FROM admins WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Username is already taken.";
    } else {
        // Insert new admin into the database
        $insertQuery = "INSERT INTO admins (username, password) VALUES (?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("ss", $username, $password);
        if ($insertStmt->execute()) {
            // Redirect to login page after successful registration
            header('Location: index.php');
            exit;
        } else {
            $error = "Error creating admin account. Please try again.";
        }
    }
}
?>

<?php
include('header.php');
?>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Admin Signup</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="signup.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Create Account</button>
        </form>
        <p class="text-center mt-3"><a href="index.php">Back to Login</a></p>
    </div>
</body>
<?php
include('footer.php');
?>
