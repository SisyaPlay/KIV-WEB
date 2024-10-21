<?php
    session_start();
    $user_id = $_SESSION['user_id'];
    global $connect;
    require_once 'vendor/connect.php';

    if (!isset($_SESSION['user_id'])) {
        header("location: index.php");
        exit();
    }

    // Предполагается, что вы уже реализовали функцию получения пользователя по ID
    $query = $connect->prepare("SELECT * FROM users WHERE id = ?");
    $query->bind_param('i', $user_id);
    $query->execute();
    $result = $query->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $picture = $user['picture'];
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
    } else {
        echo "User not found.";
        exit();
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
                        <img src="<?php echo $picture ?>" alt="User Avatar" class="user-avatar" id="userAvatar" />
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

    <!--<script src="assets/js/main.js"></script>-->
    <script src="assets/js/login.js"></script>
    <script src="assets/js/articlesContainer.js"></script>
    <script src="assets/js/bootstrap.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="assets/js/fontawesome.js" crossorigin="anonymous"></script>

</body>
</html>
