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

    <!-- Заголовок -->
    <header>
        <div class="left-buttons">
            <button onclick="location.href='index.php'">Home</button>
            <button>Album</button>
        </div>
        <div class="right-buttons">
            <div class="dropdown">
                <button id="loginBtn">Login</button>
                <div class="dropdown-content" id="loginDropdown">
                    <form id="loginForm" action="vendor/signin.php" method="post">
                        <label for="username">Username:</label>
                        <div class="input-wrapper">
                            <input type="text" name="username" id="username" placeholder="Type your username">
                            <span class="error-message" id="username-error">Username cannot be empty</span>
                        </div>
                        <label for="password">Password:</label>
                        <div class="input-wrapper">
                            <input type="password" name="password" id="password" placeholder="Type your password">
                            <span class="error-message" id="password-error">Password is required</span>
                        </div>

                        <div class="checkbox-container">
                            <input type="checkbox" id="checkbox" name="checkbox">
                            <label for="checkbox" class="checkbox-container">Remember me</label>
                        </div>

                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
            <button onclick="location.href='register.php'">Sign Up</button>
        </div>
    </header>

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

</body>
</html>
