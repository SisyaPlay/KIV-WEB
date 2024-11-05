<?php
    session_start();
    if (isset($_SESSION['user_id'])) {
        header("Location: main.php");
    }

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
    <form id="signupForm" action="../vendor/signup.php" method="post">
        <label>Username</label>
        <div class="input-wrapper">
            <input type="text" name="username" id="username-" placeholder="Type your username">
            <span class="error-message" id="username--error"></span>
        </div>

        <label>e-mail</label>
        <div class="input-wrapper">
            <input type="email" name="email" id="email" placeholder="Type your email">
            <span class="error-message" id="email-error"></span>
        </div>

        <label>Password</label>
        <div class="input-wrapper">
            <input type="password" name="password" id="password-" placeholder="Type your password">
            <span class="error-message" id="password--error"></span>
        </div>

        <label>Confirm password</label>
        <div class="input-wrapper">
            <input type="password" name="password_confirm" id="password_confirm" placeholder="Confirm your password">
            <span class="error-message" id="password_confirm-error"></span>
        </div>

        <button type="submit">Sign up</button>
    </form>

    <!-- Включение JavaScript -->
    <script src="../assets/js/signupValidation.js"></script>
    <script src="../assets/js/bootstrap.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../assets/js/fontawesome.js" crossorigin="anonymous"></script>
    <script src="../assets/js/login.js"></script>

    <?php if(isset($_SESSION['errors'])): ?>
        <script id="server-errors" type="application/json"><?= json_encode($_SESSION['errors']); ?></script>
        <?php unset($_SESSION['errors']); ?>
    <?php else: ?>
        <script id="server-errors" type="application/json">[]</script>
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

</body>
</html>
