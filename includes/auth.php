"<?php // Role-based authentication middleware ?>" 
<?php
// auth.php

// Check if the user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_role']);
}

// Redirect to the login page if not logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /public/login.php');
        exit();
    }
}

// Check if the logged-in user is an admin
function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

// Redirect to the homepage if the user is not an admin
function requireAdmin() {
    if (!isAdmin()) {
        header('Location: /public/index.php');
        exit();
    }
}
?>
