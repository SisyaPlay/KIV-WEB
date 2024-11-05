<?php
    session_start();
    require_once 'vendor/connect.php';
    global $connect;

    // Проверка куки для автоматического входа
    if (isset($_COOKIE['user_login'])) {
        $user_id = $_COOKIE['user_login'];

        // Устанавливаем идентификатор пользователя в сессии
        $_SESSION['user_id'] = $user_id;
    }

    // Проверяем, установлен ли идентификатор пользователя в сессии
    if (isset($_SESSION['user_id'])) {
        // Получаем идентификатор пользователя из сессии
        $user_id = $_SESSION['user_id'];

        // Получаем информаци   ю о пользователе
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

        // Проверяем права пользователя
        $userRoleQuery = $connect->prepare("SELECT * FROM roles WHERE id = ?");
        $userRoleQuery->bind_param('i', $role_id);
        $userRoleQuery->execute();
        $userRoleResult = $userRoleQuery->get_result();

        if ($userRoleResult && $userRoleResult->num_rows > 0) {
            $role = $userRoleResult->fetch_assoc();
            $hasPermission = $role['editPermission'];
        } else {
            $hasPermission = 0; // По умолчанию, если роль не найдена
        }
    }
    $hasPermission = 0;
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


    <?php
    if ($hasPermission):
        ?>
        <div class="main-container">
            <label class="center-label">News</label>
            <button id="create-article-btn" onclick="window.location.href='create_article.php'">Создать</button>
            <div id="article-list"></div>
        </div>
    <?php else: ?>
        <div class="main-container">
            <label class="center-label">News</label>
            <div id="article-list"></div>
        </div>
    <?php endif; ?>

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

    <!--<script src="assets/js/main.js"></script>-->
    <script src="../assets/js/login.js"></script>
    <script src="../assets/js/articlesContainer.js"></script>
    <script src="../assets/js/bootstrap.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../assets/js/fontawesome.js" crossorigin="anonymous"></script>

</body>
</html>
