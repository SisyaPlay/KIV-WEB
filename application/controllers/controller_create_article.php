<?php

Class Controller_Create_Article extends Controller {
    public function __construct() {
        $this->model = new Model_Create_Article();
        $this->view = new View();
    }

    public function action_index() {
        if (isset($_SESSION['user_id']) && $_SESSION['allowCreate'] === 0) {
            $_SESSION['message'] = "Access denied";
            header("Location: /main");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title']);
            $content = trim($_POST['content']);
            $username = $_SESSION['username'];

            if ($this->model->post_article($title, $content, $username)) {
                $_SESSION['registered'] = 'success';
                header("Location: /main");
                exit();
            } else {
                $_SESSION['message'] = "something went wrong";
                header("Location: /create_article");
            }
        } else {
            $this->view->generate("create_article_view.php", "template_view.php");
        }
    }

}
