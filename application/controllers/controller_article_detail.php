<?php

class Controller_Article_Detail extends Controller {
    public function __construct() {
        $this->model = new Model_Article_Detail();
        $this->view = new View();
    }

    public function action_index() {
        // Получаем ID статьи из GET-запроса
        $articleId = $_GET['id'] ?? null;
        $user_id = $_SESSION['user_id'] ?? null;

        if (!$articleId) {
            $_SESSION['massage'] = "Данной статьи не существует";
            header("Location: /main");
            exit();
        }

        // Получение данных для статьи
        $data['article_id'] = $articleId;
        $data['article'] = $this->model->get_article($articleId);
        $data['images'] = $this->model->get_images($articleId);
        $data['comments'] = $this->model->get_comments($articleId);
        $data['permissions'] = $this->model->get_user_permissions($user_id);

        // Генерация представления
        $this->view->generate("article_detail_view.php", "template_view.php", $data);
    }

}
