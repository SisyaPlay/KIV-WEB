<?php
class controller_Login extends controller {
    function __construct() {
        $this->model = new model_Login();
        $this->view = new View();
    }

    public function action_index() {
        // Проверка, авторизован ли пользователь
        if (isset($_SESSION['user_id'])) {
            // Если пользователь уже авторизован, перенаправляем на главную страницу
            header('Location: /main');
            exit();
        }

        $data = ["login_status" => ""]; // Инициализируем массив для передачи данных в вид

        // Проверяем, отправлена ли форма
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $rememberMe = isset($_POST['checkbox']);

            // Попытка авторизации через модель
            $authResult = $this->model->authenticate($username, $password, $rememberMe);

            if ($authResult['success']) {
                // Успешная авторизация, перенаправляем на главную страницу
                header('Location: /main');
                exit();
            } else {
                // Ошибка авторизации, передаем сообщение в вид
                $data["login_status"] = implode(", ", $authResult['errors']);  // Преобразуем массив ошибок в строку
            }
        }

        $this->view->generate('login_view.php', 'template_view.php', $data);
    }
}
