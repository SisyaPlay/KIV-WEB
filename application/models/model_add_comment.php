<?php

class Model_Add_Comment extends Model {
  public function add_comment($articleId, $userId, $content, $parentId = null) {
      if (!empty($content)) {
          // Подготовленный запрос для добавления комментария
          $stmt = $this->mysql->prepare("INSERT INTO comments (article_id, user_id, parent_id, content, created_at) VALUES (?, ?, ?, ?, NOW())");
          $stmt->bind_param("iiis", $articleId, $userId, $parentId, $content);
          $stmt->execute();
          $stmt->close();
      }
  }
}
