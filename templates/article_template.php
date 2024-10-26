<?php
// /templates/article_template.php
if (!isset($article)) {
    echo '<p>Article not found.</p>';
    return;
}
?>

<div class="article">
    <h1><?php echo htmlspecialchars($article['title']); ?></h1>
    <p class="text-muted">Published on: <?php echo date('F j, Y', strtotime($article['created_at'])); ?></p>
    <div class="article-content">
        <?php echo nl2br(htmlspecialchars($article['content'])); ?>
    </div>
</div>
