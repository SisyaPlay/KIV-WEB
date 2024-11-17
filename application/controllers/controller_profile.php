<?php

class Controller_Profile extends Controller {
    public function __construct() {
        $this->model = new Model_Profile();
        $this->view = new View();
    }

    public function action_index() {
        $data['permissions'] = $this->model->get_user_permissions($_SESSION['user_id']);
        $data['user'] = $this->model->get_user_info($_SESSION['user_id']);
        $this->view->generate("profile_view.php", "template_view.php", $data);
    }
}
