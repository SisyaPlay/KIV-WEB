<?php

class Model_Login extends Model {
    public function authenticate($username, $password, $rememberMe) {
        $errors = [];

        // Проверка на пустые поля
        if (empty($username)) {
            $errors[] = "Username cannot be empty";
        }
        if (empty($password)) {
            $errors[] = "Password is required";
        }

        // Если есть ошибки, возвращаем их
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        // Проверка пользователя в базе данных
        $query = $this->mysql->prepare("SELECT * FROM users WHERE username = ?");
        $query->bind_param('s', $username);
        $query->execute();
        $user = $query->get_result()->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            // Успешная авторизация, сохраняем данные пользователя в сессии
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($rememberMe) {
                // Устанавливаем cookie, если пользователь выбрал "Запомнить меня"
                setcookie("user_login", $user['id'], time() + (86400 * 3), "/");
            }

            return ['success' => true];
        } else {
            // Ошибка авторизации
            $errors[] = "Invalid username or password";
            return ['success' => false, 'errors' => $errors];
        }
    }
}
