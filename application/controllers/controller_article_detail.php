<?php

class Controller_Article_Detail extends Controller {
    protected $language;

    public function __construct() {
        $this->model = new Model_Article_Detail();
        $this->view = new View();
        $this->language = new Language();
    }

    public function action_index() {
        // Получаем ID статьи из GET-запроса
        $articleId = $_GET['id'] ?? null;
        $user_id = $_SESSION['user_id'] ?? null;

        if (!$articleId) {
            $_SESSION['message'] = $this->language->translate('noarticle');
            header("Location: /main");
            exit();
        }

        // Получение данных для статьи
        $data['article_id'] = $articleId;
        $data['article'] = $this->model->get_article($articleId);
        $data['images'] = $this->model->get_images($articleId);
        $data['comments'] = $this->model->get_comments($articleId);
        $data['permissions'] = $this->model->get_user_permissions($user_id);

        // Переводы для вывода в шаблоне
        $data['translations'] = [
            'comment' => $this->language->translate('comment'),
            'putcomment' => $this->language->translate('putcomment'),
            'loginforcomment' => $this->language->translate('loginforcomment'),
            'notallowcomment' => $this->language->translate('notallowcomment'),
            'nocomments' => $this->language->translate('nocomments'),
            'reply' => $this->language->translate('reply'),
            'login' => $this->language->translate('login'),
            'replycomment' => $this->language->translate('replycomment'),
            'send' => $this->language->translate('send'),
            'home' => $this->language->translate('home'),
            'album' => $this->language->translate('album'),
            'signin' => $this->language->translate('signin'),
            'signup' => $this->language->translate('signup'),
            'logout' => $this->language->translate('logout'),
            'username' => $this->language->translate('username'),
            'password' => $this->language->translate('password'),
            'rememberme' => $this->language->translate('rememberme'),
            'sumbit' => $this->language->translate('sumbit'),
            'typepass' => $this->language->translate('typepass'),
            'typename' => $this->language->translate('typename')
        ];

        // Генерация представления
        $this->view->generate("article_detail_view.php", "template_view.php", $data);
    }

    public function action_add_comment() {
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
                $_SESSION['message'] = $this->language->translate('incorrectdata');
            }
        }

        header("Location: /main");
        exit();
    }
}
