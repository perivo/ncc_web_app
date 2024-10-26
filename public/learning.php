<?php
// /public/learning.php
include('../includes/header.php');
include('../includes/config.php');

// Fetch all learning materials (update this line as necessary)
$learningQuery = "SELECT * FROM learning_materials ORDER BY id DESC"; 
$learningResult = $conn->query($learningQuery);
?>

<div class="container mt-5">
    <h2>Learning Materials</h2>
    <ul class="list-group">
        <?php while ($material = $learningResult->fetch_assoc()): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <!-- Title of the material -->
                <span><?php echo htmlspecialchars($material['title']); ?></span>

                <!-- View and Download buttons -->
                <div>
            

                    <!-- Download Button: Downloads the file -->
                    <a href="<?php echo htmlspecialchars($material['file_path']); ?>" download class="btn btn-success btn-sm ms-2">
                        Download
                    </a>
                </div>
            </li>
        <?php endwhile; ?>
    </ul>
</div>

<?php include('../includes/footer.php'); ?>
