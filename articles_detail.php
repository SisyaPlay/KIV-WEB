<?php
    session_start();
    $articleId = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    global $connect;
    require_once 'vendor/connect.php'; // Подключаем файл с базой данных

    // Подготовка SQL-запроса для получения данных статьи
    $query = $connect->prepare("SELECT title, content FROM articles WHERE id = ?");
    $query->bind_param("i", $articleId); // Привязываем параметр ID статьи
    $query->execute();
    $result = $query->get_result();

    // Проверяем, нашлась ли статья
    if ($result->num_rows > 0) {
        $article = $result->fetch_assoc(); // Получаем данные статьи
    } else {
        $article = null;
    }

    // Получение изображений, связанных с этой статьей
    $imageQuery = $connect->prepare("SELECT picture FROM article_pictures WHERE article_id = ?");
    $imageQuery->bind_param("i", $articleId);
    $imageQuery->execute();
    $imageResult = $imageQuery->get_result();

    $images = [];
    while ($row = $imageResult->fetch_assoc()) {
        $images[] = $row['picture']; // Сохраняем пути к изображениям
    }

    // Получаем информацию о пользователе
    $userQuery = $connect->prepare("SELECT * FROM users WHERE id = ?");
    $userQuery->bind_param('i', $user_id);
    $userQuery->execute();
    $userResult = $userQuery->get_result();

    if ($userResult && $userResult->num_rows > 0) {
        $user = $userResult->fetch_assoc();
        $picture = $user['picture'];
    }
    include 'assets/php/navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project-m Blog</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="main-container">
        <div class="carousel">
            <div class="carousel-images">
                <?php foreach ($images as $index => $image): ?>
                    <div class="carousel-item" data-index="<?php echo $index; ?>">
                        <img src="<?php echo htmlspecialchars($image); ?>" alt="Article Image">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="thumbnails-wrapper">
            <div class="thumbnails">
                <?php foreach ($images as $index => $image): ?>
                    <div class="thumbnail" data-index="<?php echo $index; ?>">
                        <img src="<?php echo htmlspecialchars($image); ?>" alt="Thumbnail Image">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php if ($article): ?>
            <h1><?php echo htmlspecialchars($article['title']); ?></h1>
            <p><?php echo $article['content']; ?></p>
        <?php else: ?>
            <p>Article not found.</p>
        <?php endif; ?>
    </div>

    <?php
    if(@$_SESSION['registered']) {
        echo '<p class="registeredMessage">' . $_SESSION['registered']. '</p>';
        echo '<script>
                    setTimeout(function() {
                        var message = document.querySelector(".registeredMessage");
                        if (message) {
                            message.classList.add("fadeOut");
                        }
                    }, 1000); 
                  </script>';
    }
    unset($_SESSION['registered']);
    ?>

    <?php
    if(@$_SESSION['massage']) {
        echo '<p class="msg">' . $_SESSION['massage']. '</p>';
        echo '<script>
                    setTimeout(function() {
                        var message = document.querySelector(".msg");
                        if (message) {
                            message.classList.add("fadeOut");
                        }
                    }, 1000); 
                  </script>';
    }
    unset($_SESSION['massage']);
    ?>

    <script src="assets/js/login.js"></script>
    <script src="assets/js/imageCarousel.js"></script>
    <script src="assets/js/bootstrap.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="assets/js/fontawesome.js" crossorigin="anonymous"></script>
</body>
</html>