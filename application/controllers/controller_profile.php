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

    public function action_upload_avatar() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /main");
            exit();
        }

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $user_id = $_SESSION['user_id'];
            $file = $_FILES['avatar'];

            if ($this->model->upload_avatar($user_id, $file)) {
                $_SESSION['registered'] = 'success';
                header("Location: /profile");
                // header("Refresh:0");
            } else {
                $_SESSION['massage'] = 'Ошибка при обновлении аватара.';
                header("Location: /profile");
            }
        } else {
            $_SESSION['massage'] = 'Файл не был загружен.';
            header("Location: /profile");
        }
    }
}
