<?php

namespace php\core;

class Route
{
    static function start()
    {
        // контроллер и действие по умолчанию
        $controller_name = "Task";
        $action_name = "index";

        $routes = explode("/", $_SERVER["REQUEST_URI"]);

        // получаем имя контроллера
        if (!empty($routes[1])) {
            $controller_name = ucfirst($routes[1]);
        }

        // получаем имя экшена
        if (!empty($routes[2])) {
            $action_name = strtolower($routes[2]);
        }

        $controller_path = "php/controllers/" . $controller_name . "Controller";

        if (!file_exists($controller_path . ".php")) {
            Route::ErrorPage404();
        }

        $controller_name = str_replace("/", "\\", $controller_path);
        $action_name = "action_" . $action_name;

        $controller = new $controller_name;
        $action = $action_name;

        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            Route::ErrorPage404();
        }

    }

    function ErrorPage404()
    {
        $host = "http://" . $_SERVER["HTTP_HOST"] . "/";
        header("HTTP/1.1 404 Not Found");
        header("Status: 404 Not Found");
        header("Location:" . $host . "NotFound");
    }
}
