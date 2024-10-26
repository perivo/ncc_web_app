<?php
// /public/enrollment.php
include('../includes/header.php');
include('../includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    // Remove age if not needed
    $phone = $_POST['phone'];
    $unit = $_POST['unit'];
    $message = $_POST['message'];

    // Update SQL query to remove age
    $enrollmentQuery = "INSERT INTO enrollments (applicant_name, email, phone, unit, additional_info, status, submitted_at) VALUES (?, ?, ?, ?, ?, 'pending', NOW())";
    $stmt = $conn->prepare($enrollmentQuery);
    $stmt->bind_param("sssss", $name, $email, $phone, $unit, $message);

    if ($stmt->execute()) {
        // Display success message
        echo '<p class="alert alert-success">Thank you, ' . htmlspecialchars($name) . '. Your enrollment has been successfully received.</p>';
    } else {
        // Display error message
        echo '<p class="alert alert-danger">There was an error processing your enrollment. Please try again.</p>';
    }

    $stmt->close();
}
?>

<h2>NCC Enrollment Form</h2>
<form method="POST" action="enrollment.php">
    <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <!-- Remove the age field if not needed -->
    <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="text" class="form-control" id="phone" name="phone" required>
    </div>
    <div class="form-group">
        <label for="unit">Preferred NCC Unit</label>
        <select class="form-control" id="unit" name="unit" required>
            <option value="Army Wing">Army Wing</option>
            <option value="Navy Wing">Navy Wing</option>
            <option value="Air Force Wing">Air Force Wing</option>
        </select>
    </div>
    <div class="form-group">
        <label for="message">Additional Information</label>
        <textarea class="form-control" id="message" name="message" rows="5"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Enroll Now</button>
</form>

<?php include('../includes/footer.php'); ?>
