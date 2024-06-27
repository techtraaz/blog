<?php
include 'db.php';

$limit = 5; // Number of articles per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? $_GET['search'] : '';

if ($search) {
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE title LIKE :search OR content LIKE :search ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
    $search_param = "%$search%";
    $stmt->bindParam(':search', $search_param, PDO::PARAM_STR);
} else {
    $stmt = $pdo->prepare("SELECT * FROM articles ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
}

$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_stmt = $pdo->prepare("SELECT COUNT(*) FROM articles WHERE title LIKE :search OR content LIKE :search");
$total_stmt->bindParam(':search', $search_param, PDO::PARAM_STR);
$total_stmt->execute();
$total_articles = $total_stmt->fetchColumn();
$total_pages = ceil($total_articles / $limit);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Home</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Blog Articles</h1>
    <form method="GET" action="index.php">
        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search articles...">
        <button type="submit">Search</button>
    </form>

    <?php foreach ($articles as $article): ?>
        <div class="article-preview">
            <?php
            $article_slug = strtolower(str_replace(' ', '-', $article['title']));
            ?>
            <h2><a href="<?= $article_slug ?>.php"><?= htmlspecialchars($article['title']) ?></a></h2>
            <p><?= $article['content'] ?></p> <!-- Output content directly -->
        </div>
    <?php endforeach; ?>

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="index.php?page=<?= $page - 1 ?>&search=<?= htmlspecialchars($search) ?>">&laquo; Previous</a>
        <?php endif; ?>

        <?php if ($page < $total_pages): ?>
            <a href="index.php?page=<?= $page + 1 ?>&search=<?= htmlspecialchars($search) ?>">Next &raquo;</a>
        <?php endif; ?>
    </div>
</body>
</html>
