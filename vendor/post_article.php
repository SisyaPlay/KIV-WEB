<?php
    ini_set('upload_max_filesize', '128M');
    ini_set('post_max_size', '128M');

    session_start();
    global $connect;
    require_once 'connect.php';

    $user_role = $_SESSION['role'];
    $username = $_SESSION['username'];

    if ($user_role < 1) {
        $_SESSION['message'] = "Access denied";
        header("Location: ../index.php");
        exit();
    }

    $title = $_POST['title'];
    $creation_date = date('Y-m-d H:i:s');
    $content = $_POST['content'];
    $media_files = $_FILES['media'];

    // Начинаем транзакцию для того, чтобы все действия были атомарными
    $connect->begin_transaction();

    try {
        // SQL-запрос для добавления новости
        $query = $connect->prepare("INSERT INTO articles (title, content, author, date) VALUES (?, ?, ?, ?)");
        $query->bind_param("ssss", $title, $content, $username, $creation_date);

        if (!$query->execute()) {
            throw new Exception("Error while inserting article");
        }

        // Получаем ID только что добавленной новости
        $article_id = $connect->insert_id;

        $files = $media_files['name'];
        foreach ($files as $key => $file_name) {
            if ($file_name) { // Проверяем, что файл существует
                $file_tmp_name = $media_files['tmp_name'][$key];
                $file_path = 'uploads/' . time() . '_' . basename($file_name);

                if (move_uploaded_file($file_tmp_name, '../' . $file_path)) {
                    $image_query = $connect->prepare("INSERT INTO article_pictures (article_id, picture) VALUES (?, ?)");
                    $image_query->bind_param("is", $article_id, $file_path);
                    if (!$image_query->execute()) {
                        throw new Exception("Error while inserting media");
                    }
                } else {
                    throw new Exception("Error while uploading file: " . $file_name);
                }
            }
        }

        // Если всё прошло успешно, фиксируем транзакцию
        $connect->commit();

        $_SESSION['registered'] = "An article has been posted";
        header("Location: ../index.php");
        exit();

    } catch (Exception $e) {
        // Если возникла ошибка, откатываем транзакцию
        $connect->rollback();

        $_SESSION['massage'] = "There is an error: " . $e->getMessage();
        header("Location: ../index.php");
        exit();
    }
