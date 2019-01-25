<?php

abstract class Route
{
    public static function start()
    {
        // контроллер и действие по умолчанию
        $controllerName = 'currency';

        $actionName = 'index';

        $parts =  parse_url($_SERVER['REQUEST_URI']);

        $routes = explode('/', $parts['path']);

        // получаем имя контроллера
        if ( !empty($routes[1]) ) {

            $controllerName = $routes[1];

        }

        // получаем имя экшена
        if ( !empty($routes[2]) ) {

            $actionName = $routes[2];

        }

        // парсим параметры если есть
        if(isset($parts['query'])){

            parse_str($parts['query'], $arguments);

            switch($_SERVER['REQUEST_METHOD']){
                case 'GET':
                    $_GET = $arguments;
                    break;
                case 'POST':
                    $_POST = $arguments;
                    break;
            }

        }

        // добавляем префикс к методу контролера
        $actionName = 'action'.ucfirst($actionName);

        // цепляем файл с классом контроллера
        $controllerFile = ucfirst($controllerName).'.php';

        $controllerPath = "app/controllers/".$controllerFile;

        if(file_exists($controllerPath)) {

            require_once "app/controllers/".$controllerFile;

        } else {

            throw new Exception("404 - контролер $controllerName не найден");

        }

        // создаем контроллер
        $controller = new $controllerName();

        $action = $actionName;

        if(method_exists($controller, $action)) {
            // вызываем действие контроллера
            $controller->$action();

        } else {

            throw new Exception("404 - в контролере $controllerName не найден метод $action");

        }

    }

    private static function ErrorPage404()
    {
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.$host.'404');
    }
}