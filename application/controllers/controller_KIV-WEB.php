<?php

class controller_Main extends controller {

    public function __construct() {
        $this->model = new Model_KIV-WEB();
        $this->view = new view();
    }

    public function action_index() {
        // Проверка куки для автоматического входа
        if (isset($_COOKIE['user_login'])) {
            $_SESSION['user_id'] = $_COOKIE['user_login'];
        }

        // Проверяем, установлен ли идентификатор пользователя в сессии
        if (isset($_SESSION['user_id'])) {
            $user = $this->model->getUserById($_SESSION['user_id']);

            if ($user) {
                $role = $this->model->getUserRole($user['role']);
                $hasPermission = $role ? $role['editPermission'] : 0;
            } else {
                $hasPermission = 0;
            }

            $data = [
                'user' => $user,
                'hasPermission' => $hasPermission
            ];

            $this->view->generate('Main_View.php', 'template_view.php', $data);
        } else {
            header("Location: login.php");
            exit();
        }
    }
}