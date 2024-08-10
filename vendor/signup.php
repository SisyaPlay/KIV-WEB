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

    if ($username === '') {
    $hasError = true;
    $errors[] = 'Username is required';
    }

    if ($email === '') {
        $hasError = true;
        $errors[] = 'Email is required';
    }

    if ($password === '') {
        $hasError = true;
        $errors[] = 'Password is required';
    }

    if ($password_comfirm === '') {
        $hasError = true;
        $errors[] = 'Password confirmation is required';
    }

    if ($password !== $password_comfirm) {
        $hasError = true;
        $errors[] = 'Passwords do not match';
    }

    if ($hasError) {
        $_SESSION['errors'] = $errors;
        header('Location: ../register.php');
        exit();
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);

        mysqli_query($connect, "INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES (NULL, '$username', '$password', NULL)");

        $_SESSION['registered'] = 'Registered!';
        header("Location: ../index.php");
        exit();
    }