<?php
// /templates/gallery_template.php
if (!isset($images) || count($images) === 0) {
    echo '<p>No images found in the gallery.</p>';
    return;
}
?>

<div class="gallery">
    <div class="row">
        <?php foreach ($images as $image): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?php echo htmlspecialchars($image['image_path']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($image['caption']); ?>">
                    <div class="card-body">
                        <p class="card-text"><?php echo htmlspecialchars($image['caption']); ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
