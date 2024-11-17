<?php

class Controller_Upload_Avatar extends Controller {
    public function __construct() {
        $this->model = new Model_Upload_Avatar();
    }

    public function action_index() {
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
