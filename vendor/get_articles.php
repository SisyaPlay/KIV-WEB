<?php
    session_start();
    global $connect;
    require_once 'connect.php'; // Подключение файла, где инициализируется $connect

    // Подготовка SQL-запроса
    $stmt = $connect->prepare("SELECT * FROM articles ORDER BY `date` DESC");

    // Выполнение запроса
    $stmt->execute();

    // Получение результата
    $result = $stmt->get_result();

    // Создание массива для хранения всех статей
    $articles = [];

    // Получение всех строк результата
    while ($row = $result->fetch_assoc()) {
        $articles[] = $row;
    }

    // Возврат данных в формате JSON
    header('Content-Type: application/json');
    echo json_encode($articles);
?>
