<?php

class Controller_Logout extends Controller
{
    function __construct()
    {
    }

    function action_index()
    {
        session_unset();
        session_unset();
        session_destroy();

        setcookie("user_login", "", time() - 3600, "/");

        header("Location: /main");
    }

}
