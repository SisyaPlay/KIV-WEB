<?php

class Controller_Register extends Controller {
    public function __construct() {
        $this->model = new Model_Register();
        $this->view = new View();
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
        $this->view->generate('register_view.php', 'template_view.php');
    }
}
