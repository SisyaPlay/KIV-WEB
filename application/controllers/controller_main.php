<?php

class controller_Main extends controller {
    function __construct() {
      $this->model = new model_Main();
      $this->view = new View();
    }

    public function action_index() {
        $data = $this->model->get_data();  // Данные пользователя или другие данные
        $articles = $this->model->get_articles();  // Статьи из базы данных

        // Передаем данные в шаблон
        $datafinal = array('user_data' => $data, 'articles' => $articles);
        $this->view->generate('Main_View.php', 'template_view.php', $datafinal);
    }
}
