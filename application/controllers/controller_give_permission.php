<?php

Class Controller_Give_Permission extends Controller {
    public function __construct() {
        $this->model = new Model_Give_Permission();
        $this->view = new View();
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
