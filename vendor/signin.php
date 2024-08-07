<?php
    global $connect;
    session_start();
    require_once "connect.php";

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Предотвращение SQL инъекций
    $username = mysqli_real_escape_string($connect, $username);

    // Запрос к базе данных для получения хэша пароля
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($connect, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $hash = $user['password'];

        // Проверка пароля
        if (password_verify($password, $hash)) {
            // Пароль верный
            $_SESSION['registered'] = "You are logged in successfully";
            header('Location: ../index.php');
        } else {
            $_SESSION['massage'] = "Invalid username or password";
            header('Location: ../index.php');
        }
    } else {
        $_SESSION['massage'] = "Invalid username or password";
            header('Location: ../index.php');
    }

