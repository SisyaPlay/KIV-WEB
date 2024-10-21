<?php
    session_start();
    require_once 'connect.php';
    global $connect;

    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Проверяем, был ли загружен файл
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        // Путь для сохранения загруженных аватаров
        $uploads_dir = '../uploads/';

        // Создаем папку, если её нет
        if (!is_dir($uploads_dir)) {
            mkdir($uploads_dir, 0777, true);
        }

        // Получаем информацию о файле
        $file_tmp = $_FILES['avatar']['tmp_name'];
        $file_name = basename($_FILES['avatar']['name']);
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

        // Новое имя файла для предотвращения конфликтов
        $new_file_name = $user_id.'_'. time() . '.' . $file_extension;

        // Полный путь к файлу
        $file_path = $uploads_dir . $new_file_name;

        // Перемещаем загруженный файл в директорию
        if (move_uploaded_file($file_tmp, $file_path)) {
            // Обновляем запись в базе данных
            $query = $connect->prepare("UPDATE users SET picture = ? WHERE id = ?");
            $query->bind_param('si', $file_path, $user_id);

            if ($query->execute()) {
                // Если успешно, перенаправляем на страницу профиля
                header("Location: ../profile.php");
                exit();
            } else {
                echo "Ошибка при обновлении аватара в базе данных.";
            }
        } else {
            echo "Ошибка при загрузке файла.";
        }
    } else {
        echo "Файл не был загружен.";
    }
?>
