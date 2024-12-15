<?php

$host = 'localhost';
$dbname = 'gallery_db';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
    exit;
}


$stmt = $pdo->query("SELECT * FROM images ORDER BY upload_time DESC");
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Галерея</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Галерея изображений</h1>


<?php if (isset($_GET['message'])): ?>
    <div class="message <?= htmlspecialchars($_GET['class']) ?>">
        <?= htmlspecialchars($_GET['message']) ?>
    </div>
<?php endif; ?>

<form action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="images[]" accept="image/png, image/jpeg" multiple required>
    <button type="submit">Загрузить изображения</button>
</form>

<div class="gallery">
    <?php
    // Выводим изображения
    foreach ($images as $image) {
        echo '<img src="' . $image['file_path'] . '" alt="Изображение" class="thumbnail" onclick="openModal(\'' . $image['file_path'] . '\')">';
    }
    ?>
</div>


<div id="myModal" class="modal" onclick="closeModal()">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="modalImage">
    <div id="caption"></div>
</div>

<script src="script.js"></script>
</body>
</html>
