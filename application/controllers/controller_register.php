<?php

class Controller_Register extends Controller {
    public function __construct() {
        $this->model = new Model_Register();
        $this->view = new View();
        $this->language = new Language();
    }

    public function action_index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Получаем данные из формы
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $password_confirm = trim($_POST['password_confirm']);

            // Выполняем регистрацию
            $result = $this->model->register($username, $email, $password, $password_confirm);

            if ($result['success']) {
                // Успешная регистрация
                $_SESSION['registered'] = 'Registered successfully!';
                $_SESSION['user_id'] = $result['user_id'];

                // Перенаправление на главную страницу
                header("Location: /main");
                exit();
            } else {
                // Ошибки при регистрации
                $_SESSION['massage'] = $result['errors'];
                header('Location: /register');
                exit();
            }
        }
        $data['translations'] = [
          'news' => $this->language->translate('news'),
          'create' => $this->language->translate('create'),
          'home' => $this->language->translate('home'),
          'album' => $this->language->translate('album'),
          'signin' => $this->language->translate('signin'),
          'signup' => $this->language->translate('signup'),
          'logout' => $this->language->translate('logout'),
          'username' => $this->language->translate('username'),
          'password' => $this->language->translate('password'),
          'email' => $this->language->translate('email'),
          'typename' => $this->language->translate('typename'),
          'typepass' => $this->language->translate('typepass'),
          'typeemail' => $this->language->translate('comfirmpass'),
          'typecomfpass' => $this->language->translate('typecomfpass'),
          'comfirmpass' => $this->language->translate('comfirmpass'),
          'signup' => $this->language->translate('signup'),
          'rememberme' => $this->language->translate('rememberme'),
          'sumbit' => $this->language->translate('sumbit')
        ];
        $this->view->generate('register_view.php', 'template_view.php', $data);
    }
}
