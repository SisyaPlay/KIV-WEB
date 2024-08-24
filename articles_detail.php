<?php
    session_start();
    $articleId = $_GET['id'];
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project-m Blog</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
<!--    <div class="background"></div>-->
    <!--  Заголовок -->

    <label class="main-label">Project-M</label>
    <header>
        <div class="left-buttons">
            <button class="button" onclick="location.href='index.php'">Home</button>
            <button class="button">Album</button>
        </div>

        <?php if (isset($_SESSION['user_id'])): ?>
                <div class="dropdown-profile">
                    <button class="profileBtn" id="profileBtn"></button>
                    <div class="dropdown-profile-content" id="profileDropdown">
                        <form id="profileForm">
                            <div class="profilePic"></div>
                            <div>Change your profile picture</div>
                            <input type="file" id="myFile" name="filename">
                            <button class="button" id="changePass">Change password</button>
                            <button class="button" type="button" id="logoutBtn">Logout</button>
                        </form>
                    </div>
                </div>
        <?php endif; ?>
    </header>

    <div class="main-container">
        <?php if ($article): ?>
            <h1><?php echo htmlspecialchars($article['title']); ?></h1>
            <p><?php echo nl2br(htmlspecialchars($article['content'])); ?></p>
        <?php else: ?>
            <p>Article not found.</p>
        <?php endif; ?>
    </div>

    <script src="assets/js/main.js"></script>
    <script src="assets/js/profile.js"></script>
</body>
</html>
