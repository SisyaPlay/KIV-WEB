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

    <!--  Заголовок -->

    <header>
        <div class="left-buttons">
            <button onclick="location.href='index.php'">Home</button>
            <button>Album</button>
        </div>
    </header>

    <form action="vendor/signup.php" method="post">
        <label>Username</label>
        <input type="text" name="username" placeholder="Type your username">
        <label>e-mail</label>
        <input type="email" name="email" placeholder="Type your email">
        <label>Password</label>
        <input type="password" name="password" placeholder="Type your password">
        <label>Comfirm password</label>
        <input type="password" name="password_comfirm" placeholder="Comfirm your password">
        <button type="submit">Sign up</button>
    </form>
    <?php
        if(@$_SESSION['massage']) {
            echo '<p class="msg">' . $_SESSION['massage']. '</p>';
        }
        unset($_SESSION['massage']);
    ?>
</body>
</html>
