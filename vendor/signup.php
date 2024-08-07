<?php

    global $connect;
    session_start();
    require_once 'connect.php';


    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_comfirm = $_POST['password_comfirm'];

    if($password === $password_comfirm){

        $password = password_hash($password, PASSWORD_DEFAULT);

        mysqli_query($connect, "INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES (NULL, '$username', '$password',  NULL)");

        $_SESSION['registered'] = 'Registered!';
        header("location: ../index.php");

    } else {
        $_SESSION['massage'] = 'Passwords do not match';
        header('Location: ../register.php');
    }