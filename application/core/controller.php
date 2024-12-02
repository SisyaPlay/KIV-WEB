<?php

class controller {
    public $model;
    public $view;
    protected $language;

    function __construct() {
        $this->view = new view();
        $this->language = new Language();
    }

    function action_index() {
    }
}
