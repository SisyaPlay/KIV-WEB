<?php

class Controller_Add_Comment extends Controller {
    public function __construct() {
        $this->model = new Model_Add_Comment();
    }

    public function action_index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Обработка добавления комментария
            $articleId = $_POST['article_id'] ?? null;
            $content = trim($_POST['content'] ?? '');
            $parentId = $_POST['parent_id'] ?? null;

            if ($articleId && $content) {
                $this->model->add_comment($articleId, $_SESSION['user_id'], $content,  $parentId);
                header("Location: /article_detail?id=$articleId");
                exit();
            } else {
                $_SESSION['error'] = "Некорректные данные.";
            }
        }

        header("Location: /main");
        exit();
    }
}
