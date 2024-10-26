<?php
// /public/register.php
session_start();
include('../includes/header.php');
include('../includes/config.php');

$message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate form inputs
    if ($password !== $confirmPassword) {
        $message = 'Passwords do not match.';
    } else {
        // Check if the email already exists
        $emailCheckQuery = "SELECT * FROM users WHERE email = '$email'";
        $emailCheckResult = $conn->query($emailCheckQuery);

        if ($emailCheckResult->num_rows > 0) {
            $message = 'Email already exists. Please use a different email.';
        } else {
            // Hash the password before storing
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $insertQuery = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashedPassword', 'user')";
            if ($conn->query($insertQuery) === TRUE) {
                $message = 'Registration successful! You can now log in.';
            } else {
                $message = 'Error: ' . $conn->error;
            }
        }
    }
}
?>

<div class="container mt-4">
    <h2>Register</h2>
    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
    <p class="mt-3">Already have an account? <a href="login.php">Login here</a>.</p>
</div>

<?php include('../includes/footer.php'); ?>
