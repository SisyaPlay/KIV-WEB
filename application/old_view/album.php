<?php
session_start();
global $connect;
require_once 'vendor/connect.php';

// Проверка куки для автоматического входа
if (isset($_COOKIE['user_login'])) {
    $user_id = $_COOKIE['user_login'];
    $_SESSION['user_id'] = $user_id;
}

// Проверяем, установлен ли идентификатор пользователя в сессии
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Получаем информацию о пользователе
    $query = $connect->prepare("SELECT * FROM users WHERE id = ?");
    $query->bind_param('i', $user_id);
    $query->execute();
    $result = $query->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $picture = $user['picture'];
        $role_id = $user['role'];
    } else {
        echo "User not found.";
        exit();
    }
}

// Получаем все изображения из таблицы article_pictures
$query = $connect->prepare("SELECT picture FROM article_pictures");
$query->execute();
$result = $query->get_result();

$images = [];
while ($row = $result->fetch_assoc()) {
    $images[] = $row['picture'];
}

include 'assets/php/navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project-m Blog - Gallery</title>
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="main-container">
        <div class="gallery-grid">
            <?php foreach ($images as $index => $image): ?>
                <img src="<?= htmlspecialchars($image); ?>" alt="Gallery Image" onclick="openModal(<?= $index ?>)">
            <?php endforeach; ?>
        </div>

        <!-- Модальное окно для отображения изображения -->
        <div id="modal" class="modal">
            <span class="close" onclick="closeModal()">&times;</span>
            <img class="modal-content" id="modal-image">
            <a class="prev" onclick="changeImage(-1)">&#10094;</a>
            <a class="next" onclick="changeImage(1)">&#10095;</a>
        </div>
    </div>

    <script id="gallery-data" src="../assets/js/galleryModal.js"><?= json_encode($images); ?></script>
    <script src="../assets/js/bootstrap.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../assets/js/fontawesome.js" crossorigin="anonymous"></script>
</body>
</html>
