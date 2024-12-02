<?php

Class Controller_Give_Permission extends Controller {
    public function __construct() {
        $this->model = new Model_Give_Permission();
        $this->view = new View();
        $this->language = new Language();
    }

    public function action_index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /main");
            exit();
        }

        $role = $this->model->getRoleById($_SESSION['user_id']);
        if (!$role || $role['givePermission'] != 1) {
            header("Location: /main");
            exit();
        }


        $data['users'] = $this->model->getAllUsers();
        $data['roles'] = $this->model->getAllRoles();
        $data['translations'] = [
          'news' => $this->language->translate('news'),
          'create' => $this->language->translate('create'),
          'home' => $this->language->translate('home'),
          'album' => $this->language->translate('album'),
          'signin' => $this->language->translate('signin'),
          'signup' => $this->language->translate('signup'),
          'logout' => $this->language->translate('logout'),
          'changerole' => $this->language->translate('changerole'),
          'id' => $this->language->translate('id'),
          'username' => $this->language->translate('username'),
          'role' => $this->language->translate('role'),
          'rolesnotfound' => $this->language->translate('rolesnotfound'),
          'usernotfound' => $this->language->translate('usernotfound'),
          'savechanges' => $this->language->translate('savechanges'),
          'password' => $this->language->translate('password'),
          'rememberme' => $this->language->translate('rememberme'),
          'sumbit' => $this->language->translate('sumbit'),
          'typepass' => $this->language->translate('typepass'),
          'typename' => $this->language->translate('typename')
        ];

        $this->view->generate("give_permission_view.php", "template_view.php", $data);
    }

    public function action_update_roles() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['roles'])) {
                $this->model->updateUserRoles($_POST['roles']);
            }
            header("Location: /give_permission");
            exit();
        }
    }
}
