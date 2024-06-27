<?php
include 'db.php';

// Fetch authors to populate the dropdown
$authors_stmt = $pdo->query("SELECT * FROM authors");
$authors = $authors_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Article</title>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        #editor {
            height: 400px;
        }
    </style>
</head>
<body>
    <!-- <form action="save_article.php" method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required><br>
        <label for="content">Content:</label><br>
        <div id="editor"></div>
        <input type="hidden" name="content" id="content">
        <label for="author">Author:</label><br>
        <select id="author" name="author_id" required>
            <?php foreach ($authors as $author): ?>
                <option value="<?= $author['id'] ?>"><?= htmlspecialchars($author['name']) ?></option>
            <?php endforeach; ?>
        </select><br>
        <button type="submit">Create Article</button>
        
    </form>
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    ['image', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    ['clean']
                ]
            }
        });

        var form = document.querySelector('form');
        form.onsubmit = function() {
            var content = document.querySelector('input[name=content]');
            content.value = quill.root.innerHTML;
        };
    </script> -->


    <form action="save_article.php" method="POST" enctype="multipart/form-data">
    <label for="title">Title:</label><br>
    <input type="text" id="title" name="title" required><br>
    <label for="editor">Content:</label><br>
    <div id="editor"></div>
    <input type="hidden" name="content" id="content">
    <label for="author">Author:</label><br>
    <select id="author" name="author_id" required>
        <?php foreach ($authors as $author): ?>
            <option value="<?= $author['id'] ?>"><?= htmlspecialchars($author['name']) ?></option>
        <?php endforeach; ?>
    </select><br>
    <button type="submit">Create Article</button>
</form>

<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline'],
                ['image', 'code-block'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['clean']
            ]
        }
    });

    var form = document.querySelector('form');
    form.onsubmit = function() {
        var content = document.querySelector('input[name=content]');
        content.value = quill.root.innerHTML;
    };
</script>

</body>
</html>
