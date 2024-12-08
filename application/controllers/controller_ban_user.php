<?php

class Controller_Ban_User extends Controller {
    public function __construct() {
        $this->model = new Model_Ban_User();
        $this->view = new View();
        $this->language = new Language();
    }

    public function action_index() {
        // Получаем информацию о пользователе и список пользователей для бана
        $userData = $this->model->getUserData($_SESSION['user_id']);
        $data['users'] = $this->model->getUsersToBan($_SESSION['user_id']);

        $role = $this->model->getRoleById($userData['role']);
        if (!$role || $role['allowBan'] != 1) {
            header("Location: /main");
            exit();
        }

        $data['translations'] = [
          'home' => $this->language->translate('home'),
          'album' => $this->language->translate('album'),
          'signin' => $this->language->translate('signin'),
          'signup' => $this->language->translate('signup'),
          'logout' => $this->language->translate('logout'),
          'banunban' => $this->language->translate('banunban'),
          'id' => $this->language->translate('id'),
          'username' => $this->language->translate('username'),
          'ban' => $this->language->translate('ban'),
          'savechanges' => $this->language->translate('savechanges'),
          'usernotfound' => $this->language->translate('usernotfound'),
          'password' => $this->language->translate('password'),
          'rememberme' => $this->language->translate('rememberme'),
          'sumbit' => $this->language->translate('sumbit'),
          'typepass' => $this->language->translate('typepass'),
          'typename' => $this->language->translate('typename'),
          'username' => $this->language->translate('username'),
          'password' => $this->language->translate('password'),
          'rememberme' => $this->language->translate('rememberme'),
          'sumbit' => $this->language->translate('sumbit'),
          'typepass' => $this->language->translate('typepass'),
          'typename' => $this->language->translate('typename')];

        // Генерируем представление с переданными данными
        $this->view->generate("ban_user_view.php", "template_view.php", $data);
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
