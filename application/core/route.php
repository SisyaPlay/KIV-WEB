<?php

class Route
{
    static function start()
    {
        session_start();

        // Контроллер и действие по умолчанию
        $controller_name = 'Main';
        $action_name = 'index';

        // Разделяем URI и параметры
        $request_uri = explode('?', $_SERVER['REQUEST_URI']); // Разделяем строку запроса
        $routes = explode('/', trim($request_uri[0], '/'));   // Убираем начальный и конечный слэши

        // Получаем имя контроллера
        if (!empty($routes[0])) {
            $controller_name = $routes[0];
        }

        // Получаем имя действия
        if (!empty($routes[1])) {
            $action_name = $routes[1];
        }

        // Добавляем префиксы
        $model_name = 'Model_' . $controller_name;
        $controller_name = 'Controller_' . $controller_name;
        $action_name = 'action_' . $action_name;

        // Подключаем файл модели (если существует)
        $model_file = strtolower($model_name) . '.php';
        $model_path = "application/models/" . $model_file;
        if (file_exists($model_path)) {
            include $model_path;
        }

        // Подключаем файл контроллера
        $controller_file = strtolower($controller_name) . '.php';
        $controller_path = "application/controllers/" . $controller_file;
        if (file_exists($controller_path)) {
            include $controller_path;
        } else {
            // Перенаправление на 404
            self::ErrorPage404();
        }

        // Создаём контроллер
        $controller = new $controller_name;
        $action = $action_name;

        // Проверяем существование метода
        if (method_exists($controller, $action)) {
            // Вызываем действие контроллера
            $controller->$action();
        } else {
            // Перенаправление на 404
            self::ErrorPage404();
        }
    }

    static function ErrorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . '404');
    }
}
