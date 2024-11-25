<?php

class Controller_Ban_User extends Controller {
    public function __construct() {
        $this->model = new Model_Ban_User();
        $this->view = new View();
    }

    public function action_index() {
        // Получаем информацию о пользователе и список пользователей для бана
        $userData = $this->model->getUserData($_SESSION['user_id']);
        $users = $this->model->getUsersToBan($_SESSION['user_id']);

        $role = $this->model->getRoleById($userData['role']);
        if (!$role || $role['allowBan'] != 1) {
            header("Location: /main");
            exit();
        }

        // Генерируем представление с переданными данными
        $this->view->generate("ban_user_view.php", "template_view.php", $users);
    }

    public function action_ban_user() {
        $bannedUsers = isset($_POST['banUsers']) ? $_POST['banUsers'] : [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model->updateBanStatus($bannedUsers, $_SESSION['user_id']);
        }
        header("Location: /ban_user");
        exit();
    }
}
