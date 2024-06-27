<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate inputs
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $author_id = isset($_POST['author_id']) ? $_POST['author_id'] : '';

    // Validate the author_id
    $author_stmt = $pdo->prepare("SELECT * FROM authors WHERE id = ?");
    $author_stmt->execute([$author_id]);
    $author = $author_stmt->fetch(PDO::FETCH_ASSOC);

    if ($author) {
        // Function to handle image uploads from Quill content
        function handleImageUploads($content) {
            preg_match_all('/<img.*?src="(.*?)".*?>/is', $content, $matches);

            $uploadedImages = [];

            foreach ($matches[1] as $imageUrl) {
                $imageData = file_get_contents($imageUrl);
                $imageName = basename($imageUrl);
                $imagePath = 'uploads/' . $imageName;
                file_put_contents($imagePath, $imageData);
                $uploadedImages[] = $imagePath;
            }

            return $uploadedImages;
        }

        // Handle image uploads
        $uploadedImages = handleImageUploads($content);

        // Prepare and execute the SQL query to insert article data
        $imagePathsJSON = json_encode($uploadedImages);
        $stmt = $pdo->prepare("INSERT INTO articles (title, content, author_id, image_paths) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $content, $author_id, $imagePathsJSON]);

        echo "Article created successfully!";
    } else {
        echo "Invalid author ID.";
    }
}
?>
