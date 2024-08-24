<?php
ini_set('upload_max_filesize', '128M');
ini_set('post_max_size', '128M');

session_start();
global $connect;
require_once 'connect.php';

if (!isset($_SESSION['role']) || !isset($_SESSION['username'])) {
    $_SESSION['message'] = "Session data missing";
    header("Location: ../index.php");
    exit();
}

$user_role = $_SESSION['role'];
$username = $_SESSION['username'];

if ($user_role < 1) {
    $_SESSION['message'] = "Access denied";
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = isset($_POST['title']) ? trim($_POST['title']) : null;
    $content = isset($_POST['content']) ? trim($_POST['content']) : null;
    $media_files = isset($_FILES['media']) ? $_FILES['media'] : null;
    $creation_date = date('Y-m-d H:i:s');

    if (empty($title) || empty($content)) {
        $_SESSION['message'] = "Title and content are required.";
        header("Location: ../index.php");
        exit();
    }

    // Начинаем транзакцию для того, чтобы все действия были атомарными
    $connect->begin_transaction();

    try {
        // SQL-запрос для добавления статьи
        $query = $connect->prepare("INSERT INTO articles (title, content, author, date) VALUES (?, ?, ?, ?)");
        $query->bind_param("ssss", $title, $content, $username, $creation_date);

        if (!$query->execute()) {
            throw new Exception("Error while inserting article");
        }

        // Получаем ID только что добавленной статьи
        $article_id = $connect->insert_id;

        if ($media_files && !empty($media_files['name'][0])) {
            $files = $media_files['name'];
            $normalizeImages = [];

            foreach ($files as $key_name => $value) {
                foreach ($value as $key => $item) {
                    $normalizeImages[$key][$key_name] = $item;
                }
            }

            foreach ($normalizeImages as $image) {
                $allowed_types = ["image/*", "video/*", "image/gif"];
                $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
                $file_name = time() . ".$extension";
                $file_path = 'uploads/' . $file_name;

                if (!in_array(mime_content_type($image['tmp_name']), $allowed_types)) {
                    throw new Exception("Incorrect file type: " . $image['name']);
                }

                if (move_uploaded_file($image["tmp_name"], '../' . $file_path)) {
                    $image_query = $connect->prepare("INSERT INTO article_pictures (article_id, picture) VALUES (?, ?)");
                    $image_query->bind_param("is", $article_id, $file_path);
                    if (!$image_query->execute()) {
                        throw new Exception("Error while inserting media: " . $image['name']);
                    }
                } else {
                    throw new Exception("Error while uploading file: " . $image['name']);
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

        $_SESSION['message'] = "There was an error: " . $e->getMessage();
        header("Location: ../index.php");
        exit();
    }
} else {
    $_SESSION['message'] = "Invalid request method.";
    header("Location: ../index.php");
    exit();
}
?>
