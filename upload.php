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


if (isset($_FILES['images'])) {
    $uploadDirectory = 'images/';
    $messages = [];


    foreach ($_FILES['images']['name'] as $key => $fileName) {
        $fileTmpName = $_FILES['images']['tmp_name'][$key];
        $fileError = $_FILES['images']['error'][$key];

        if ($fileError === UPLOAD_ERR_OK) {

            $newFileName = uniqid() . '_' . basename($fileName);
            $filePath = $uploadDirectory . $newFileName;


            if (move_uploaded_file($fileTmpName, $filePath)) {

                $stmt = $pdo->prepare("INSERT INTO images (file_path, upload_time) VALUES (?, NOW())");
                $stmt->execute([$filePath]);

                $messages[] = 'Загрузка выполнена успешно!';
            } else {
                $messages[] = 'Ошибка при выполнении загрузки.';
            }
        } else {
            $messages[] = 'Ошибка при загрузке файла.';
        }
    }


    if (!empty($messages)) {
        $message = implode(" ", $messages);
        header("Location: index.php?message=" . urlencode($message) . "&class=success");
        exit();
    }
} else {
    header("Location: index.php?message=Не выбраны файлы&class=error");
    exit();
}
?>
