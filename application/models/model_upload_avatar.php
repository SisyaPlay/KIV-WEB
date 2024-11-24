<?php

class Model_Upload_Avatar extends Model {
  public function upload_avatar($user_id, $file) {
      $uploads_dir = 'application/uploads/';

      // Создаем папку, если её нет
      if (!is_dir($uploads_dir)) {
          mkdir($uploads_dir, 0777, true);
      }

      // Получаем информацию о файле
      $file_tmp = $file['tmp_name'];
      $file_name = basename($file['name']);
      $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

      // Генерируем новое имя файла
      $new_file_name = $user_id . '_' . time() . '.' . $file_extension;

      // Полный путь к файлу
      $file_path = $uploads_dir . $new_file_name;

      // Получаем текущую аватарку пользователя из базы данных
      $query = $this->mysql->prepare("SELECT picture FROM users WHERE id = ?");
      $query->bind_param('i', $user_id);
      $query->execute();
      $query->bind_result($current_picture);
      $query->fetch();
      $query->close();

      // Удаляем старую аватарку, если она существует
      if (!empty($current_picture) && file_exists($current_picture)) {
          unlink($current_picture);
      }

      // Перемещаем файл
      if (move_uploaded_file($file_tmp, $file_path)) {
          // Обновляем запись в базе данных
          $query = $this->mysql->prepare("UPDATE users SET picture = ? WHERE id = ?");
          $query->bind_param('si', $file_path, $user_id);
          if ($query->execute()) {
              $_SESSION['picture'] = $file_path;
              return true;
          }
      }
      return false;
    }

}
