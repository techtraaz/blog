<?php
include 'db.php';

$slug = $_GET['slug'];
$title = str_replace('-', ' ', $slug);

$stmt = $pdo->prepare("SELECT * FROM articles WHERE LOWER(REPLACE(title, ' ', '-')) = ?");
$stmt->execute([$slug]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    die("Article not found.");
}

// Decode JSON-encoded image paths
$imagePaths = json_decode($article['image_paths'], true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article['title']) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1, h2, h3 {
            font-family: 'Arial Black', sans-serif;
            color: #333;
        }
        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px; /* Optional: Add margin between images */
            display: block; /* Ensures images are displayed as block elements */
        }
    </style>
</head>
<body>
    <h1><?= htmlspecialchars($article['title']) ?></h1>

    <!-- Display all images first -->
    <!-- <?php foreach ($imagePaths as $imagePath): ?>
        <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($article['title']) ?>">
    <?php endforeach; ?> -->

    <!-- Display article content after images -->
    <div>
        <?= $article['content'] ?>
    </div>
</body>
</html>
