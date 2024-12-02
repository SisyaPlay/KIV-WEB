<?php

class Controller_Album extends Controller {
    public function __construct() {
        $this->model = new Model_Album();
        $this->view = new View();
        $this->language = new Language();
    }

    public function action_index() {
        $data = $this->model->get_images();
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
        $this->view->generate("album_view.php", "template_view.php", $data);
    }
}
