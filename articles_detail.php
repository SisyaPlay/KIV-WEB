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
    <div class="background"></div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <!-- Лейбл слева -->
            <a class="navbar-brand" href="#">Project-M</a>

            <!-- Вкладки по центру -->
            <div class="mx-auto order-0">
                <ul class="navbar-nav" style="display: flex; justify-content: center; width: 100%;">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="fas fa-home"></i> Home <!-- Иконка домика -->
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-images"></i> Album <!-- Иконка альбома -->
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Кнопки справа -->
            <div class="navbar-nav ml-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Отображаем аватар пользователя -->
                    <a class="nav-link" href="profile.php" id="userProfileLink" aria-expanded="false">
                        <img src="<?php echo $picture ?>" alt="User Avatar" class="user-avatar" />
                    </a>

                    <!-- Комбобокс для смены языка -->
                    <select class="form-control" id="languageSelect">
                        <option value="en">English</option>
                        <option value="ru">Русский</option>
                    </select>

                <?php else: ?>
                    <!-- Кнопка для открытия модального окна входа -->
                    <a class="nav-link" href="#" id="signInBtn">Sign In</a>
                    <div class="dropdown-login" id="loginDropdown" style="display: none;">
                        <div class="dropdown-login-content">
                            <form id="loginForm" action="vendor/signin.php" method="post">
                                <label for="username">Username:</label>
                                <div class="input-wrapper">
                                    <input type="text" name="username" id="username" placeholder="Type your username">
                                    <span class="error-message" id="username-error"></span>
                                </div>
                                <label for="password">Password:</label>
                                <div class="input-wrapper">
                                    <input type="password" name="password" id="password" placeholder="Type your password">
                                    <span class="error-message" id="password-error"></span>
                                </div>

                                <div class="checkbox-container">
                                    <input type="checkbox" id="checkbox" name="checkbox">
                                    <label for="checkbox" class="checkbox-container">Remember me</label>
                                </div>

                                <button type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                    <a class="nav-link" href="register.php">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

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

    <script src="assets/js/login.js"></script>
    <script src="assets/js/imageCarousel.js"></script>
    <script src="assets/js/bootstrap.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="assets/js/fontawesome.js" crossorigin="anonymous"></script>
</body>
</html>