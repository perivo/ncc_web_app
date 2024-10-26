<?php
// /public/index.php
include('../includes/header.php');
include('../includes/config.php');

// Fetch recent articles
$articleQuery = "SELECT * FROM articles ORDER BY id DESC LIMIT 3";
$articleResult = $conn->query($articleQuery);

// Fetch recent gallery images
$galleryQuery = "SELECT * FROM gallery ORDER BY id DESC LIMIT 12"; // Adjust the limit as needed
$galleryResult = $conn->query($galleryQuery);
?>

<div class="jumbotron text-center">
    <h1>Welcome to NCC Web Application</h1>
    <p>Your gateway to NCC information, articles, and resources.</p>
</div>

<!-- Recent Articles -->
<h2 class="text-center mt-5 mb-4">Latest Articles</h2>
<div class="container">
    <div class="row justify-content-center">
        <?php while ($article = $articleResult->fetch_assoc()): ?>
            <div class="col-md-4 d-flex align-items-stretch">
                <div class="card mb-4 shadow-lg border-0" style="overflow:hidden; position:relative;">
                    <!-- Article Image -->
                    <?php if (!empty($article['image_path'])): ?>
                        <img src="../<?php echo htmlspecialchars($article['image_path']); ?>" class="card-img-top article-image" alt="Article Image" style="object-fit: cover; height: 200px;">
                    <?php else: ?>
                        <img src="../assets/images/default-article.jpg" class="card-img-top article-image" alt="Default Image" style="object-fit: cover; height: 200px;">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($article['title']); ?></h5>
                        <p class="card-text"><?php echo substr(htmlspecialchars($article['content']), 0, 100) . '...'; ?></p>
                        <a href="../public/articles.php?id=<?php echo $article['id']; ?>" class="btn btn-outline-primary">Read More</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Masonry Gallery -->
<h2 class="text-center mt-5 mb-4">Gallery</h2>
<div class="container gallery-container">
    <div class="row gallery-row">
        <?php while ($image = $galleryResult->fetch_assoc()): ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4 gallery-item">
                <div class="gallery-image-wrapper">
                    <img src="<?php echo htmlspecialchars($image['image_path']); ?>" class="img-fluid rounded shadow-sm" alt="<?php echo htmlspecialchars($image['caption']); ?>">
                    <?php if (!empty($image['caption'])): ?>
                        <div class="image-caption">
                            <?php echo htmlspecialchars($image['caption']); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<a href="../public/gallery.php" class="btn btn-secondary d-block mt-3 mb-5 text-center">View More</a>

<?php include('../includes/footer.php'); ?>

<style>
    /* Article Card Styling */
    .card {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
    }

    .article-image {
        transition: transform 0.3s ease;
    }

    .card:hover .article-image {
        transform: scale(1.05);
    }

    /* Masonry Gallery Styling */
    .gallery-container {
        padding: 20px 0;
    }

    .gallery-row {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .gallery-item {
        overflow: hidden;
        position: relative;
    }

    .gallery-image-wrapper {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        transition: transform 0.3s ease-in-out;
    }

    .gallery-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease-in-out;
    }

    .gallery-image-wrapper:hover {
        transform: scale(1.02);
    }

    .image-caption {
        position: absolute;
        bottom: 10px;
        left: 10px;
        right: 10px;
        background-color: rgba(0, 0, 0, 0.6);
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 0.9rem;
        text-align: center;
        transition: opacity 0.3s;
        opacity: 0;
    }

    .gallery-image-wrapper:hover .image-caption {
        opacity: 1;
    }

    /* Responsive Gallery */
    @media (max-width: 768px) {
        .gallery-item {
            width: 100%;
        }
    }
</style>
