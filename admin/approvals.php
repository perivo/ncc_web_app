<?php
// /admin/dashboard.php
session_start();
include('../includes/config.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}
// Fetch all pending enrollment forms
$enrollmentsQuery = "SELECT * FROM enrollments WHERE status = 'pending' ORDER BY submitted_at DESC";
$enrollmentsResult = $conn->query($enrollmentsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Enrollment Forms</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
    <?php include('header.php'); ?>
    <div class="container mt-5">
        <h1>Approve Enrollment Forms</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Applicant Name</th>
                    <th>Email</th>
                    <th>Submitted Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($enrollment = $enrollmentsResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($enrollment['applicant_name']); ?></td>
                        <td><?php echo htmlspecialchars($enrollment['email']); ?></td>
                        <td><?php echo date('F j, Y', strtotime($enrollment['submitted_at'])); ?></td>
                        <td><?php echo htmlspecialchars($enrollment['status']); ?></td>
                        <td>
                            <form action="../scripts/approval_actions.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $enrollment['id']; ?>">
                                <input type="hidden" name="action" value="approve">
                                <button type="submit" class="btn btn-success">Approve</button>
                            </form>
                            <form action="../scripts/approval_actions.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $enrollment['id']; ?>">
                                <input type="hidden" name="action" value="reject">
                                <button type="submit" class="btn btn-danger">Reject</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>
