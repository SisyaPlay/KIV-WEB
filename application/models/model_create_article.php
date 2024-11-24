<?php

Class Model_Create_Article extends Model {
    public function hasAccess($userId) {
        // Подготовка запроса
        $stmt = $this->mysql->prepare("
            SELECT r.allowCreate
            FROM roles r
            JOIN users u ON u.role = r.id
            WHERE u.id = ?
        ");
        $stmt->bind_param("i", $userId); // Связывание параметра
        $stmt->execute(); // Выполнение запроса

        // Получение результата
        $result = $stmt->get_result();
        $row = $result->fetch_assoc(); // Извлечение строки результата

        // Проверка права
        return $row && $row['allowCreate'] == 1;
    }


    public function post_article($title, $content, $username) {
        $creation_date = date('Y-m-d H:i:s');
        $stmt = $this->mysql->prepare("INSERT INTO articles (title, content, author, date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $content, $username, $creation_date);

        if ($stmt->execute()) {
            $article_id = $stmt->insert_id;

            if (!empty($_FILES['media']['name'][0])) {
                $uploadDir = 'application/uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4'];

                foreach ($_FILES['media']['name'] as $key => $filename) {
                    $fileTmpPath = $_FILES['media']['tmp_name'][$key];
                    $fileType = $_FILES['media']['type'][$key];

                    if (in_array($fileType, $allowedTypes)) {
                        $filePath = $uploadDir . time() . basename($filename);

                        if (move_uploaded_file($fileTmpPath, $filePath)) {
                            $stmtMedia = $this->mysql->prepare("INSERT INTO article_pictures (article_id, picture) VALUES (?, ?)");
                            $stmtMedia->bind_param("is", $article_id, $filePath);
                            $stmtMedia->execute();
                        }
                    }
                }
            }
            return true;
        } else {
            return false;
        }
    }
}
