<?php

class Model_Article_Detail extends Model {
    public function get_article($articleId) {
        $query = $this->mysql->prepare("SELECT title, content FROM articles WHERE id = ?");
        $query->bind_param("i", $articleId);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function get_images($articleId) {
        $query = $this->mysql->prepare("SELECT picture FROM article_pictures WHERE article_id = ?");
        $query->bind_param("i", $articleId);
        $query->execute();
        $result = $query->get_result();

        $images = [];
        while ($row = $result->fetch_assoc()) {
            $images[] = $row['picture'];
        }
        return $images;
    }

    public function get_comments($articleId) {
        $query = $this->mysql->prepare("SELECT c.content, c.created_at, u.username
                                    FROM comments c
                                    JOIN users u ON c.user_id = u.id
                                    WHERE c.article_id = ?
                                    ORDER BY c.created_at DESC");
        $query->bind_param("i", $articleId);
        $query->execute();
        return $query->get_result();
    }

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
}
