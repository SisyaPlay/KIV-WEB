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

          // Выполняем аутентификацию
          $result = $this->model->authenticate($username, $password, $rememberMe);

          if ($result['success']) {
              $_SESSION['registered'] = "You are logged in successfully";
              header("Location: /main"); // Перенаправление на главную страницу
          } else {
              // Ошибки при авторизации
              $_SESSION['massage'] = "Invalid username or password";
              header("Location: /main"); // Возврат на страницу логина
          }
      }
      $this->view->generate("main_view.php", "template_view.php");
    }
}
