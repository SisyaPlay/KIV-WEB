<?php

class Controller_Album extends Controller {
    public function __construct() {
        $this->model = new Model_Album();
        $this->view = new View();
    }

    public function action_index() {
        $data = $this->model->get_images();

        $this->view->generate("album_view.php", "template_view.php", $data);
    }
}
