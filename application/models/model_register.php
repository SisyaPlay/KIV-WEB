<?php

class Model_Register extends model {
    public function register($username, $email, $password, $password_confirm) {
         // Проверка на уникальность имени пользователя
         $query = $this->mysql->prepare("SELECT * FROM users WHERE username = ?");
         $query->bind_param('s', $username);
         $query->execute();
         if ($query->get_result()->num_rows > 0) {
             $error = 'Username already exists';
         }

         if (!empty($error)) {
             return ['success' => false, 'errors' => $error];
         }

         // Хешируем пароль
         $hashed_password = password_hash($password, PASSWORD_DEFAULT);
         $picture = 'application/assets/img/usericon.png';

         // Записываем данные в базу данных
         $query = $this->mysql->prepare("INSERT INTO users (username, password, email, role, picture) VALUES (?, ?, ?, 0, ?)");
         $query->bind_param('ssss', $username, $hashed_password, $email, $picture);
         $query->execute();

         // Возвращаем успешный результат
         return ['success' => true, 'user_id' => $this->mysql->insert_id];
    }
}
