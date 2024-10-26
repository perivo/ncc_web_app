"<?php // Login processing script ?>" 
<?php
// /scripts/login.php
include('../includes/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate user credentials
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_name'] = $user['name'];

        // Redirect based on user role
        if ($user['role'] === 'admin') {
            header('Location: /admin/dashboard.php');
        } else {
            header('Location: /public/index.php');
        }
        exit();
    } else {
        echo 'Invalid email or password.';
    }
}
?>
