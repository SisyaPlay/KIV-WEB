<?php

class Model_Main extends model {
    public function get_data() {
        if (isset($_COOKIE['user_login']) && !isset($_SESSION['user_id'])) {
            // Если в cookie есть user_login и нет сессии, устанавливаем user_id в сессии
            $_SESSION['user_id'] = $_COOKIE['user_login'];
        }

        // Проверяем, установлен ли идентификатор пользователя в сессии
        if (isset($_SESSION['user_id'])) {
            // Получаем идентификатор пользователя из сессии
            $user_id = $_SESSION['user_id'];

            // Получаем информацию о пользователе
            $query = $this->mysql->prepare("SELECT * FROM users WHERE id = ?");
            $query->bind_param('i', $user_id);
            $query->execute();
            $result = $query->get_result();

            if ($result && $result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $_SESSION['user_id'] = $user['id'];  // Убедитесь, что поле корректно
                $_SESSION['picture'] = $user['picture'];
                $_SESSION['role'] = $user['role'];
            }

            // Проверяем права пользователя
            $role_id = $_SESSION['role'];  // Используем роль из сессии
            $userRoleQuery = $this->mysql->prepare("SELECT * FROM roles WHERE id = ?");
            $userRoleQuery->bind_param('i', $role_id);
            $userRoleQuery->execute();
            $userRoleResult = $userRoleQuery->get_result();

            if ($userRoleResult && $userRoleResult->num_rows > 0) {
                $role = $userRoleResult->fetch_assoc();
                $_SESSION['allowCreate'] = $role['allowCreate'];
            } else {
                $_SESSION['allowCreate'] = 0; // По умолчанию, если роль не найдена
            }
        } else {
            $_SESSION['allowCreate'] = 0; // Если пользователь не авторизован
        }
    }

    public function get_articles() {
        // Подготовка SQL-запроса
        $stmt = $this->mysql->prepare("SELECT * FROM articles ORDER BY `date` DESC");

        // Выполнение запроса
        $stmt->execute();

        // Получение результата
        $result = $stmt->get_result();

        // Создание массива для хранения всех статей
        $data = [];

        // Заполнение массива результатами
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }
}
