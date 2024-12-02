<?php

class Controller_Profile extends Controller {
    public function __construct() {
        $this->model = new Model_Profile();
        $this->view = new View();
        $this->language = new Language();
    }

    public function action_index() {
        $data['permissions'] = $this->model->get_user_permissions($_SESSION['user_id']);
        $data['user'] = $this->model->get_user_info($_SESSION['user_id']);
        $data['articles'] = $this->model->get_articles($data['user']['username']);
        $data['translations'] = [
          'home' => $this->language->translate('home'),
          'album' => $this->language->translate('album'),
          'signin' => $this->language->translate('signin'),
          'signup' => $this->language->translate('signup'),
          'logout' => $this->language->translate('logout'),
          'email' => $this->language->translate('email'),
          'role' => $this->language->translate('role'),
          'changeavatar' => $this->language->translate('changeavatar'),
          'editpermissions' => $this->language->translate('editpermissions'),
          'givepermissions' => $this->language->translate('givepermissions'),
          'banusers' => $this->language->translate('banusers'),
          'articlename' => $this->language->translate('articlename'),
          'deleting' => $this->language->translate('deleting'),
          'delete' => $this->language->translate('delete'),
          'articlenotfound' => $this->language->translate('articlenotfound'),
          'suretodelete' => $this->language->translate('suretodelete'),
          'artsuccessdelete' => $this->language->translate('artsuccessdelete'),
          'arterrordelete' => $this->language->translate('arterrordelete'),
          'error' => $this->language->translate('error'),
          'username' => $this->language->translate('username'),
          'password' => $this->language->translate('password'),
          'rememberme' => $this->language->translate('rememberme'),
          'sumbit' => $this->language->translate('sumbit'),
          'typepass' => $this->language->translate('typepass'),
          'typename' => $this->language->translate('typename')
        ];
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

    public function action_delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id && $this->model->delete_article($id)) {
                $_SESSION['message'] = 'Статья успешно удалена.';
            } else {
                $_SESSION['message'] = 'Ошибка при удалении статьи.';
            }
        } else {
            $_SESSION['message'] = 'Неверный запрос.';
        }

        header("Location: /profile");
        exit();
    }

}
