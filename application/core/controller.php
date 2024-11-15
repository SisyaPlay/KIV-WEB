<?php

class controller {
    public $model;
    public $view;

    function __construct() {
        $this->view = new view();
    }

    function action_index() {
    }
}
