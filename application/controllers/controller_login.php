<?php

class Controller_Login extends Controller {
    public function __construct() {
        $this->model = new Model_Login();
        $this->view = new View();
        $this->language = new Language();
    }

    public function action_index() {
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
          'rememberme' => $this->language->translate('rememberme'),
          'sumbit' => $this->language->translate('sumbit'),
          'typepass' => $this->language->translate('typepass'),
          'typename' => $this->language->translate('typename')
        ];
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
                    $this->view->generate("login_view.php", "template_view.php", $data); // Страница логина
                }
                return; // Завершаем выполнение метода, чтобы избежать дополнительного вывода
            }
        } else {
            // Отображаем представление по умолчанию (на случай GET-запроса)
            $this->view->generate("login_view.php", "template_view.php", $data);
        }
    }
}
