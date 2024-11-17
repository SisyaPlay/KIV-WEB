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

          // Перемещаем файл
          if (move_uploaded_file($file_tmp, $file_path)) {
              // Обновляем запись в базе данных
              $query = $this->mysql->prepare("UPDATE users SET picture = ? WHERE id = ?");
              $query->bind_param('si', $file_path, $user_id);
              if ($query->execute()) {
                  return true;
              }
          }
          return false;
      }
}
