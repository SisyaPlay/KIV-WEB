<?php
session_start();
require_once 'connect.php'; // Подключение к базе данных
global $connect;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id'])) {
    header("location: ../index.php");
    exit();
}

$user_role = $_SESSION['role'];
$username = $_SESSION['username'];

if ($user_role < 1) {
    $_SESSION['message'] = "Access denied";
    header("Location: ../index.php");
    exit();
}

// Проверка, что данные формы были отправлены
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $user_id = $_SESSION['user_id'];
    $creation_date = date('Y-m-d H:i:s');

    // Подготовка и выполнение запроса для сохранения статьи в таблицу articles
    $stmt = $connect->prepare("INSERT INTO articles (title, content, author, date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $content, $username, $creation_date);

    if ($stmt->execute()) {
        $article_id = $stmt->insert_id; // Получение ID вставленной записи

        // Проверка, если есть загруженные файлы
        if (!empty($_FILES['media']['name'][0])) {
            $uploadDir = './uploads/'; // Директория для сохранения файлов

            // Проверка существования директории и прав доступа
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4'];

            foreach ($_FILES['media']['name'] as $key => $filename) {
                $fileTmpPath = $_FILES['media']['tmp_name'][$key];
                $fileType = $_FILES['media']['type'][$key];

                // Проверка типа файла
                if (in_array($fileType, $allowedTypes)) {
                    $filePath = $uploadDir . time() . basename($filename);

                    // Перемещение файла в директорию
                    if (move_uploaded_file($fileTmpPath, $filePath)) {
                        // Вставка информации о файле в таблицу media
                        $stmtMedia = $connect->prepare("INSERT INTO article_pictures (article_id, picture) VALUES (?, ?)");
                        $stmtMedia->bind_param("is", $article_id, $filePath);
                        $stmtMedia->execute();
                    } else {
                        echo "Ошибка: не удалось переместить файл $filename.";
                    }
                } else {
                    echo "Ошибка: недопустимый тип файла $fileType.";
                }
            }
        }

        // Перенаправление после успешной вставки статьи
        header("location: ../index.php");
        exit(); // Убедитесь, что после заголовков завершение скрипта
    } else {
        echo "Ошибка: не удалось добавить статью.";
    }
}
?>
