<?php
    session_start();
    if (isset($_SESSION['user_id'])) {
        header("Location: index.php");
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
    <!--  Заголовок -->
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
                        <img src="assets/img/userIcon.png" alt="User Avatar" class="user-avatar" />
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

    <form id="signupForm" action="vendor/signup.php" method="post">
        <label>Username</label>
        <div class="input-wrapper">
            <input type="text" name="username" id="username" placeholder="Type your username">
            <span class="error-message" id="username-error"></span>
        </div>

        <label>e-mail</label>
        <div class="input-wrapper">
            <input type="email" name="email" id="email" placeholder="Type your email">
            <span class="error-message" id="email-error"></span>
        </div>

        <label>Password</label>
        <div class="input-wrapper">
            <input type="password" name="password" id="password" placeholder="Type your password">
            <span class="error-message" id="password-error"></span>
        </div>

        <label>Confirm password</label>
        <div class="input-wrapper">
            <input type="password" name="password_comfirm" id="password_comfirm" placeholder="Confirm your password">
            <span class="error-message" id="password_comfirm-error"></span>
        </div>

        <button type="submit">Sign up</button>
    </form>

    <!-- Включение JavaScript -->
    <script src="assets/js/signupValidation.js"></script>
    <script src="assets/js/bootstrap.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="assets/js/fontawesome.js" crossorigin="anonymous"></script>

    <?php if(isset($_SESSION['errors'])): ?>
        <script id="server-errors" type="application/json"><?= json_encode($_SESSION['errors']); ?></script>
        <?php unset($_SESSION['errors']); ?>
    <?php else: ?>
        <script id="server-errors" type="application/json">[]</script>
    <?php endif; ?>


</body>
</html>
