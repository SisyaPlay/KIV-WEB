<?php
    session_start();
    $articleId = $_GET['id'];
    $user_id = $_SESSION['user_id'] ?? null; // Используем null, если пользователь не залогинен
    global $connect;
    require_once 'vendor/connect.php'; // Подключаем файл с базой данных

    // Получаем информацию о пользователе, только если он залогинен
    if ($user_id) {
        $userQuery = $connect->prepare("SELECT * FROM users WHERE id = ?");
        $userQuery->bind_param('i', $user_id);
        $userQuery->execute();
        $userResult = $userQuery->get_result();

        if ($userResult && $userResult->num_rows > 0) {
            $user = $userResult->fetch_assoc();
            $picture = $user['picture'];
            $role = $user['role'];

            // Получаем данные о роли пользователя
            $roleQuery = $connect->prepare("SELECT * FROM roles WHERE id = ?");
            $roleQuery->bind_param('i', $role);
            $roleQuery->execute();
            $roleResult = $roleQuery->get_result();

            if ($roleResult && $roleResult->num_rows > 0) {
                $roleData = $roleResult->fetch_assoc();

                // Пример использования прав для условий
                $allowCreate = $roleData['allowCreate'];
                $allowDelete = $roleData['allowDelete'];
                $allowWriteComm = $roleData['allowWriteComm'];
                $editPermission = $roleData['editPermission'];
                $allowBan = $roleData['allowBan'];
            }
        }
    } else {
        // Если пользователь не залогинен, устанавливаем права по умолчанию
        $allowWriteComm = false;
    }

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

    // Получение комментариев, связанных с этой статьей
    $commentQuery = $connect->prepare("SELECT c.content, c.created_at, u.username 
                                           FROM comments c 
                                           JOIN users u ON c.user_id = u.id 
                                           WHERE c.article_id = ? 
                                           ORDER BY c.created_at DESC");
    $commentQuery->bind_param("i", $articleId);
    $commentQuery->execute();
    $commentResult = $commentQuery->get_result();

    include 'assets/php/navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project-m Blog</title>
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<div class="main-container">
    <h1 class="center-label"><?php echo htmlspecialchars($article['title']); ?></h1>
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
        <p class="article-content"><?php echo $article['content']; ?></p> <!-- Добавлен класс -->
    <?php else: ?>
        <p>Статья не найдена.</p>
    <?php endif; ?>

    <div class="comments-section">
        <h3 class="center-label">Комментарии</h3>
        <?php if ($allowWriteComm): // Проверяем, имеет ли пользователь право писать комментарии ?>
            <input type="hidden" id="article_id" value="<?php echo $articleId; ?>">
            <textarea class="form-control" id="commentContent" rows="2" placeholder="Напишите комментарий..."></textarea>
            <a href="#" id="submitComment" class="btn btn-primary mt-2">Отправить</a>
        <?php elseif (!$user_id): ?>
            <p><a href="login.php">Войдите</a>, чтобы оставить комментарий.</p>
        <?php else: ?>
            <p>У вас нет прав для добавления комментариев.</p>
        <?php endif; ?>

        <div class="comments-list">
            <?php
            function displayComments($connect, $articleId, $parentId = null, $level = 0) {
                $query = $connect->prepare("SELECT c.id, c.content, c.created_at, u.username 
                                FROM comments c 
                                JOIN users u ON c.user_id = u.id 
                                WHERE c.article_id = ? AND c.parent_id " . ($parentId ? "= ?" : "IS NULL") . " 
                                ORDER BY c.created_at DESC");

                if ($parentId) {
                    $query->bind_param("ii", $articleId, $parentId);
                } else {
                    $query->bind_param("i", $articleId);
                }

                $query->execute();
                $result = $query->get_result();

                if ($result->num_rows > 0) {
                    while ($comment = $result->fetch_assoc()) {
                        echo "<div class='comment' style='margin-left: " . ($level * 20) . "px;'>";
                        echo "<p><strong>" . htmlspecialchars($comment['username']) . "</strong></p>";
                        echo "<p>" . nl2br(htmlspecialchars($comment['content'])) . "</p>"; // Используем nl2br
                        echo "<small style='color: gray;'>" . $comment['created_at'] . "</small>";

                        // Проверяем, имеет ли пользователь право отвечать на комментарий
                        if ($allowWriteComm) {
                            echo "<button type='button' class='btn btn-link reply-button' onclick='showReplyBox(this)'>➡️ Ответить</button>";
                        }

                        // Стрелочка
                        echo "<div class='reply-arrow' style='display:none;'>➤</div>"; // Скрываем стрелочку по умолчанию

                        // Текстовое поле для ответа на комментарий
                        echo "<div style='display:none;' class='reply-container'>";
                        echo "<div class='reply-arrow' style='display:none;'>➤</div>"; // Добавляем стрелочку слева
                        echo "<textarea class='form-control reply-textarea' rows='1' placeholder='Ответить на комментарий...' style='resize: none;'></textarea>";
                        echo "<button type='button' class='btn btn-link submit-reply' style='display:none;' onclick='submitReply(this, " . $comment['id'] . ")'>Отправить</button>";
                        echo "</div>"; // Закрываем контейнер для ответа

                        echo "</div>";

                        // Рекурсивный вызов для отображения вложенных комментариев
                        displayComments($connect, $articleId, $comment['id'], $level + 1);
                    }
                } else if ($level == 0) {
                    echo "<p>Пока нет комментариев.</p>";
                }
            }

            // Вызов функции для отображения комментариев
            displayComments($connect, $articleId);
            ?>

        </div>
    </div>
</div>

<script src="../assets/js/comments.js"></script>
<script src="../assets/js/login.js"></script>
<script src="../assets/js/imageCarousel.js"></script>
<script src="../assets/js/bootstrap.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="../assets/js/fontawesome.js" crossorigin="anonymous"></script>
</body>
</html>
