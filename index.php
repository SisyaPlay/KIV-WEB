<?php
    session_start();
    global $connect;

    if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_login'])) {
        $userId = $_COOKIE['user_login'];

        // Предполагается, что вы уже реализовали функцию получения пользователя по ID
        $query = $connect->prepare("SELECT * FROM users WHERE id = ?");
        $query->bind_param('i', $userId);
        $query->execute();
        $result = $query->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
        }
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

    <!-- Заголовок -->
    <label class="main-label">Project-M</label>
    <header>
        <div class="left-buttons">
            <button class="button" onclick="location.href='index.php'">Home</button>
            <button class="button">Album</button>
        </div>

        <div class="right-buttons">
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

            <?php else: ?>
                <!-- Если пользователь не авторизован, показываем кнопки входа и регистрации -->
                <div class="dropdown-login">
                    <button class="button" id="loginBtn">Login</button>
                    <div class="dropdown-login-content" id="loginDropdown">
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
                <button class="button" onclick="location.href='register.php'">Sign Up</button>
            <?php endif; ?>
        </div>
    </header>

    <!-- Блок с кнопкой "Создать" для пользователей с ролью 1 и выше -->
    <?php
        $user_role = $_SESSION['role'] ?? 0; // Предполагается, что роль пользователя хранится в сессии
        if ($user_role >= 1):
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
        }
        unset($_SESSION['massage']);
    ?>

    <script src="assets/js/main.js"></script>
    <script src="assets/js/profile.js"></script>
    <script src="assets/js/articlesContainer.js"></script>

</body>
</html>
