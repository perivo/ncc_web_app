"<?php // Registration processing script ?>" 
<?php
// /scripts/register.php
include('../includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'user';  // Default role for new registrations

    // Insert new user into the database
    $query = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $name, $email, $password, $role);

    if ($stmt->execute()) {
        echo 'Registration successful. You can now <a href="/public/login.php">login</a>.';
    } else {
        echo 'Error: ' . $stmt->error;
    }
}
?>
