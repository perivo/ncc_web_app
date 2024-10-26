<?php
// /public/contact.php
include('../includes/header.php');
include('../includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission (in real applications, this data would be emailed or stored)
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // For demo, just show a success message
    echo '<p>Thank you, ' . htmlspecialchars($name) . '. Your message has been received.</p>';
}
?>

<h2>Contact Us</h2>
<form method="POST" action="contact.php">
    <div class="form-group">
        <label for="name">Your Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="message">Message</label>
        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Send</button>
</form>

<?php include('../includes/footer.php'); ?>
