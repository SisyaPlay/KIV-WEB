<?php
    global $connect;
    session_start();
    require_once "connect.php";

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $rememberMe = isset($_POST['checkbox']);
    $ip = $_SERVER['REMOTE_ADDR'];

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
            $_SESSION['role'] = $user['role'];
            if ($rememberMe) {
                // Если пользователь установил чекбокс, создаем cookie для сохранения сессии

                $cookie_name = "user_login";
                $cookie_value = $user['id'];
                setcookie($cookie_name, $cookie_value, time() + (86400 * 3), "/"); // Cookie на 3 дней
            }
            $_SESSION['registered'] = "You are logged in successfully";

            header('Location: ../index.php');
            exit();
        } else {
            $_SESSION['massage'] = "Invalid username or password";
        }
    } else {
        $_SESSION['massage'] = "Invalid username or password";
    }
