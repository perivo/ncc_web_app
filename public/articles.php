<?php
// /public/articles.php
include('../includes/header.php');
include('../includes/config.php');

// If an article ID is specified, display that article
if (isset($_GET['id'])) {
    $articleId = intval($_GET['id']);
    $articleQuery = "SELECT * FROM articles WHERE id = ?";
    $stmt = $conn->prepare($articleQuery);
    $stmt->bind_param("i", $articleId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($article = $result->fetch_assoc()) {
        ?>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-lg border-0">
                        <!-- Article Image -->
                        <?php if (!empty($article['image_path'])): ?>
                            <img src="../<?php echo htmlspecialchars($article['image_path']); ?>" class="card-img-top" alt="Article Image" style="object-fit: cover; height: 300px;">
                        <?php else: ?>
                            <img src="../assets/images/default-article.jpg" class="card-img-top" alt="Default Image" style="object-fit: cover; height: 300px;">
                        <?php endif; ?>

                        <div class="card-body">
                            <h2 class="card-title"><?php echo htmlspecialchars($article['title']); ?></h2>
                            <p class="card-text"><?php echo nl2br(htmlspecialchars($article['content'])); ?></p>
                            <a href="articles.php" class="btn btn-outline-secondary mt-3">Back to Articles</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo '<div class="container mt-5"><p class="text-center">Article not found.</p></div>';
    }
} else {
    // Otherwise, display a list of all articles
    $articleQuery = "SELECT * FROM articles ORDER BY created_at DESC";
    $articleResult = $conn->query($articleQuery);
    ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">All Articles</h2>
        <div class="row">
            <?php while ($article = $articleResult->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-lg border-0 h-100">
                        <!-- Article Image -->
                        <?php if (!empty($article['image_path'])): ?>
                            <img src="../<?php echo htmlspecialchars($article['image_path']); ?>" class="card-img-top" alt="Article Thumbnail" style="object-fit: cover; height: 200px;">
                        <?php else: ?>
                            <img src="../assets/images/default-article.jpg" class="card-img-top" alt="Default Thumbnail" style="object-fit: cover; height: 200px;">
                        <?php endif; ?>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($article['title']); ?></h5>
                            <p class="card-text"><?php echo substr(htmlspecialchars($article['content']), 0, 150) . '...'; ?></p>
                            <a href="articles.php?id=<?php echo $article['id']; ?>" class="btn btn-outline-primary mt-auto">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <?php
}

include('../includes/footer.php');
?>

<style>
    /* Styling for individual article and article list */
    .card {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
    }
</style>
