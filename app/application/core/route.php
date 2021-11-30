<?php
namespace application\core;

class Route
{
    static function start()
    {
        // контроллер и действие по умолчанию
        $controller_name = 'main';
        $action_name = 'index';

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        // получаем имя контроллера
        if ( !empty($routes[1]) ) {
            $controller_name = $routes[1];
        }

        // получаем имя экшена
        if ( !empty($routes[2]) ) {
            $action_name = $routes[2];
        }

        $controller_file = strtolower("controller_$controller_name").'.php';
        $controller_path = "application/controllers/".$controller_file;

        // проверка существования контроллера
        if (file_exists($controller_path)) {
            include "application/controllers/".$controller_file;
        } else {
            Route::ErrorPage404();
        }

        // добавляем префиксы
        $controller_name = 'application\controllers\Controller_'.$controller_name;
        $action_name = 'action_'.$action_name;

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
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.$host.'404');
    }
}