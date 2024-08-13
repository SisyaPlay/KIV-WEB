<?php
    session_start();
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
    <!--  Заголовок -->

    <header>
        <div class="left-buttons">
            <button onclick="location.href='index.php'">Home</button>
            <button>Album</button>
        </div>
    </header>

    <form id="signupForm" action="vendor/signup.php" method="post">
        <label>Username</label>
        <div class="input-wrapper">
            <input type="text" name="username" id="username" placeholder="Type your username">
            <span class="error-message" id="username-error">Username is required</span>
        </div>

        <label>e-mail</label>
        <div class="input-wrapper">
            <input type="email" name="email" id="email" placeholder="Type your email">
            <span class="error-message" id="email-error">Email is required</span>
        </div>

        <label>Password</label>
        <div class="input-wrapper">
            <input type="password" name="password" id="password" placeholder="Type your password">
            <span class="error-message" id="password-error">Password is required</span>
        </div>

        <label>Confirm password</label>
        <div class="input-wrapper">
            <input type="password" name="password_comfirm" id="password_comfirm" placeholder="Confirm your password">
            <span class="error-message" id="password_comfirm-error">Password confirmation is required</span>
        </div>

        <button type="submit">Sign up</button>
    </form>

    <!-- Включение JavaScript -->
    <script src="assets/js/signupValidation.js"></script>

    <?php if(isset($_SESSION['errors'])): ?>
        <script id="server-errors" type="application/json"><?= json_encode($_SESSION['errors']); ?></script>
        <?php unset($_SESSION['errors']); ?>
    <?php else: ?>
        <script id="server-errors" type="application/json">[]</script>
    <?php endif; ?>


</body>
</html>
