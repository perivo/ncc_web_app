<?php // Display gallery images ?>
<?php
// /public/gallery.php
include('../includes/header.php');
include('../includes/config.php');

// Fetch all gallery images (update this line as necessary)
$galleryQuery = "SELECT * FROM gallery ORDER BY id DESC"; // Use an existing column if 'created_at' does not exist
$galleryResult = $conn->query($galleryQuery);
?>

<h2>Image Gallery</h2>
<div class="row">
    <?php while ($image = $galleryResult->fetch_assoc()): ?>
        <div class="col-md-3 mb-4">
            <div class="card">
                <img src="<?php echo htmlspecialchars($image['image_path']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($image['caption']); ?>">
                <div class="card-body">
                    <p class="card-text"><?php echo htmlspecialchars($image['caption']); ?></p>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php include('../includes/footer.php'); ?>
