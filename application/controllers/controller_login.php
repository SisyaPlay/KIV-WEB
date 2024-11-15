<?php

class Controller_Login extends Controller {
    public function __construct() {
        $this->model = new Model_Login();
        $this->view = new View();
    }

    public function action_index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Получаем данные из формы
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $rememberMe = isset($_POST['checkbox']);
            $redirectTo = $_POST['redirect_to'] ?? 'main';

            // Выполняем аутентификацию
            $result = $this->model->authenticate($username, $password, $rememberMe);

            if ($result['success']) {
                $_SESSION['registered'] = "Вы успешно вошли в систему";

                // Перенаправление после успешного входа
                header("Location: /main");
                exit();
            } else {
                // Ошибки при авторизации
                $_SESSION['massage'] = "Неправильное имя пользователя или пароль";

                // Устанавливаем представление в зависимости от источника попытки входа
                if ($redirectTo === 'dropdown') {
                    header("Location: /main");
                    exit();
                } else {
                    $this->view->generate("login_view.php", "template_view.php"); // Страница логина
                }
                return; // Завершаем выполнение метода, чтобы избежать дополнительного вывода
            }
        } else {
            // Отображаем представление по умолчанию (на случай GET-запроса)
            $this->view->generate("login_view.php", "template_view.php");
        }
    }
}
