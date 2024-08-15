<?php
    global $connect;
    session_start();
    require_once "connect.php";

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $errors = [];

    // Проверка на пустые поля
    if (empty($username)) {
        $errors[] = "Username cannot be empty";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: ../index.php');
        exit();
    }

    // Использование подготовленного запроса для предотвращения SQL-инъекций
    $query = $connect->prepare("SELECT * FROM users WHERE username = ?");
    $query->bind_param('s', $username);
    $query->execute();
    $result = $query->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $hash = $user['password'];

        // Проверка пароля
        if (password_verify($password, $hash)) {
            // Пароль верный
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            $_SESSION['registered'] = "You are logged in successfully";
        } else {
            $_SESSION['massage'] = "Invalid username or password";
        }
    } else {
        $_SESSION['massage'] = "Invalid username or password";
    }

    header('Location: ../index.php');
    exit();
