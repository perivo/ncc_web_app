<?php
// /scripts/approval_actions.php
include('../includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $action = $_POST['action'];

    // Determine the new status based on the action
    $newStatus = ($action === 'approve') ? 'approved' : 'rejected';

    // Update the enrollment status in the database
    $updateQuery = "UPDATE enrollments SET status = ?, updated_at = NOW() WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('si', $newStatus, $id);

    if ($stmt->execute()) {
        // Redirect back to the dashboard with a success message
        header('Location: ../admin/dashboard.php?message=success');
    } else {
        // Redirect back to the dashboard with an error message
        header('Location: ../admin/dashboard.php?message=error');
    }

    $stmt->close();
    $conn->close();
}
?>
