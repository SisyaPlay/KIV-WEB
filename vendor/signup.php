<?php
    global $connect;
    session_start();
    require_once 'connect.php';


    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_comfirm = $_POST['password_comfirm'];

    $hasError = false;
    $errors = [];

    if (empty($username)) {
        $hasError = true;
        $errors[] = 'Username is required';
    }

    if (empty($email)) {
        $hasError = true;
        $errors[] = 'Email is required';
    }

    if (empty($password)) {
        $hasError = true;
        $errors[] = 'Password is required';
    }

    if (empty($password_comfirm)) {
        $hasError = true;
        $errors[] = 'Password confirmation is required';
    }

    if ($password !== $password_comfirm) {
        $hasError = true;
        $errors[] = 'Passwords do not match';
    }

    $checkUsername = $connect->prepare("SELECT * FROM users WHERE username = ?");
    $checkUsername->bind_param("s", $username);
    $checkUsername->execute();
    $result = $checkUsername->get_result();

    if($result && $result->num_rows > 0) {
        $hasError = true;
        $errors[] = 'Username already exists';
    }

    if ($hasError) {
        $_SESSION['errors'] = $errors;
        header('Location: ../register.php');
        exit();
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $picture = 'assets/img/usericon.png';
        $query = $connect->prepare("INSERT INTO users (username, password, email, role, picture) VALUES (?, ?, ?, 0, ?)");
        $query->bind_param("ssss", $username, $hashed_password, $email, $picture);
        $query->execute();


        $_SESSION['registered'] = 'Registered!';
        header("Location: ../index.php");
        exit();
    }