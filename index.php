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
                    <form action="vendor/signin.php" method="post">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" placeholder="Type your username">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" placeholder="Type your password">

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
