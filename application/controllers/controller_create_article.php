<?php

Class Controller_Create_Article extends Controller {
    public function __construct() {
        $this->model = new Model_Create_Article();
        $this->view = new View();
        $this->language = new Language();
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
            $data['translations'] = [
              'news' => $this->language->translate('news'),
              'create' => $this->language->translate('create'),
              'home' => $this->language->translate('home'),
              'album' => $this->language->translate('album'),
              'signin' => $this->language->translate('signin'),
              'signup' => $this->language->translate('signup'),
              'logout' => $this->language->translate('logout'),
              'title' => $this->language->translate('title'),
              'text' => $this->language->translate('text'),
              'uploadvidpic' => $this->language->translate('uploadvidpic'),
              'createart' => $this->language->translate('createart'),
              'typeatitle' => $this->language->translate('typeatitle'),
              'username' => $this->language->translate('username'),
              'password' => $this->language->translate('password'),
              'rememberme' => $this->language->translate('rememberme'),
              'sumbit' => $this->language->translate('sumbit'),
              'typepass' => $this->language->translate('typepass'),
              'typename' => $this->language->translate('typename')
            ];
            $this->view->generate("create_article_view.php", "template_view.php", $data);
        }
    }

}
