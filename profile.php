<?php
session_start();
global $connect;

if (!isset($_SESSION['user_id'])) {
    header("location: index.php");
    exit();
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
    <div class="background"></div>

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

    <Form>

    </Form>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/profile.js"></script>
</body>

</html>
