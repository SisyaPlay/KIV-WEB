<?php

class Model_Profile extends Model {
    public function get_user_permissions($user_id) {
        if ($user_id) {
            $userQuery = $this->mysql->prepare("SELECT u.picture, r.*
                                            FROM users u
                                            JOIN roles r ON u.role = r.id
                                            WHERE u.id = ?");
            $userQuery->bind_param("i", $user_id);
            $userQuery->execute();
            return $userQuery->get_result()->fetch_assoc();
        }

        return [
            'allowWriteComm' => false,
            'allowCreate' => false,
            'allowDelete' => false,
            'editPermission' => false,
            'allowBan' => false
        ];
    }

    public function get_user_info($user_id) {
        if ($user_id) {
            $query = $this->mysql->prepare("SELECT * from users where id = ?");
            $query->bind_param("i", $user_id);
            $query->execute();

            return $query->get_result()->fetch_assoc();
        }
    }

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

      public function get_articles($userName) {
          $query = $this->mysql->prepare("SELECT id, title FROM articles WHERE author = ?");
          $query->bind_param("s", $userName);
          $query->execute();
          return $query->get_result()->fetch_all();
      }

      public function delete_article($id) {
          $getPictures = $this->mysql->prepare("SELECT picture FROM article_pictures WHERE article_id = ?");
          $getPictures->bind_param("i", $id);
          $getPictures->execute();
          $images = $getPictures->get_result()->fetch_all();
          $getPictures->close();

          foreach ($images as $image) {
              $filePath = $image['picture'];
              if (!empty($filePath) && file_exists($filePath)) {
                  unlink($filePath); // Удаляем файл
              }
          }

          $deletePictures = $this->mysql->prepare("DELETE FROM article_pictures WHERE article_id = ?");
          $deletePictures->bind_param("i", $id);
          $deletePictures->execute();
          $deletePictures->close();

          // Удаляем все дочерние комментарии
          // Получаем дочерние комментарии
          $getChildComments = $this->mysql->prepare("SELECT id FROM comments WHERE parent_id IN (SELECT id FROM comments WHERE article_id = ?)");
          $getChildComments->bind_param("i", $id);
          $getChildComments->execute();
          $result = $getChildComments->get_result();
          $childComments = $result->fetch_all(MYSQLI_ASSOC);
          $getChildComments->close();

          // Удаляем дочерние комментарии
          foreach ($childComments as $child) {
              $deleteChild = $this->mysql->prepare("DELETE FROM comments WHERE id = ?");
              $deleteChild->bind_param("i", $child['id']);
              $deleteChild->execute();
              $deleteChild->close();
          }

          // Удаляем комментарии, связанные с article_id
          $deleteComments = $this->mysql->prepare("DELETE FROM comments WHERE article_id = ?");
          $deleteComments->bind_param("i", $id);
          $deleteComments->execute();
          $deleteComments->close();


          // Удаляем статью из базы данных
          $deleteQuery = $this->mysql->prepare("DELETE FROM articles WHERE id = ?");
          $deleteQuery->bind_param("i", $id);
          $deleteQuery->execute();
          $deleteQuery->close();

          return true;
      }
}
