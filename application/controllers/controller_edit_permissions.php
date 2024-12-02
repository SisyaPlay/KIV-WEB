<?php

class Controller_Edit_Permissions extends Controller {
    public function __construct() {
        $this->model = new Model_Edit_Permissions();
        $this->view = new View();
        $this->language = new Language();
    }

    public function action_index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /main");
            exit();
        }

        $user_id = $_SESSION['user_id'];

        // Получение данных пользователя и проверка прав
        $user = $this->model->getUserById($user_id);
        if (!$user) {
            header("Location: /main");
            exit();
        }

        $role = $this->model->getRoleById($user['role']);
        if (!$role || $role['editPermission'] != 1) {
            header("Location: /main");
            exit();
        }

        // Получение всех ролей
        $data['roles'] = $this->model->getAllRoles();
        $data['translations'] = [
          'home' => $this->language->translate('home'),
          'album' => $this->language->translate('album'),
          'signin' => $this->language->translate('signin'),
          'signup' => $this->language->translate('signup'),
          'logout' => $this->language->translate('logout'),
          'editroles' => $this->language->translate('editroles'),
          'select' => $this->language->translate('select'),
          'rolename' => $this->language->translate('rolename'),
          'roleid' => $this->language->translate('roleid'),
          'allowread' => $this->language->translate('allowread'),
          'allowcreate' => $this->language->translate('allowcreate'),
          'allowdelete' => $this->language->translate('allowdelete'),
          'allowwritecomm' => $this->language->translate('allowwritecomm'),
          'editpermissions' => $this->language->translate('editpermissions'),
          'allowbanusers' => $this->language->translate('allowbanusers'),
          'givepermissions' => $this->language->translate('givepermissions'),
          'rolesnotfound' => $this->language->translate('rolesnotfound'),
          'savechanges' => $this->language->translate('savechanges'),
          'deleteroles' => $this->language->translate('deleteroles'),
          'createrole' => $this->language->translate('createrole'),
          'username' => $this->language->translate('username'),
          'password' => $this->language->translate('password'),
          'rememberme' => $this->language->translate('rememberme'),
          'sumbit' => $this->language->translate('sumbit'),
          'typepass' => $this->language->translate('typepass'),
          'typename' => $this->language->translate('typename')
        ];
        // Генерация страницы
        $this->view->generate("edit_permissions_view.php", "template_view.php", $data);
    }

    public function action_update_roles() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Обновление ролей
            if (isset($_POST['updateRoles'])) {
                $this->model->updateRoles($_POST);
            }

            // Удаление выбранных ролей
            if (isset($_POST['deleteRolesBtn']) && !empty($_POST['deleteRoles'])) {
                $this->model->deleteRoles($_POST['deleteRoles']);
            }

            // Создание новой роли
            if (isset($_POST['createRoleBtn'])) {
                $this->model->createNewRole();
            }

            header("Location: /edit_permissions");
            exit();
        }
    }
}
