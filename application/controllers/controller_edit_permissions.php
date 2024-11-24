<?php

class Controller_Edit_Permissions extends Controller {
    public function __construct() {
        $this->model = new Model_Edit_Permissions();
        $this->view = new View();
    }

    public function action_index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /main");
            exit();
        }

        $user_id = $_SESSION['user_id'];

        // Получение данных пользователя и проверка прав
        $user = $this->model->get_user_by_id($user_id);
        if (!$user) {
            header("Location: /main");
            exit();
        }

        $role = $this->model->get_role_by_id($user['role']);
        if (!$role || $role['editPermission'] != 1) {
            header("Location: /main");
            exit();
        }

        // Получение всех ролей
        $roles = $this->model->get_all_roles();
        // Генерация страницы
        $this->view->generate("edit_permissions_view.php", "template_view.php", $roles);
    }

    public function action_update_roles() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Обновление ролей
            if (isset($_POST['updateRoles'])) {
                $this->model->update_roles($_POST);
            }

            // Удаление выбранных ролей
            if (isset($_POST['deleteRolesBtn']) && !empty($_POST['deleteRoles'])) {
                $this->model->delete_roles($_POST['deleteRoles']);
            }

            // Создание новой роли
            if (isset($_POST['createRoleBtn'])) {
                $this->model->create_new_role();
            }

            header("Location: /edit_permissions");
            exit();
        }
    }
}
