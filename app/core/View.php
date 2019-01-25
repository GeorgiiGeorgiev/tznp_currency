<?php

class View
{
    protected $controllerName;

    public function __construct(string $controllerName)
    {
        $this->controllerName = strtolower($controllerName);
    }

    public function render(string $view = '',array $data = [])
    {
        if(is_array($data)){

            extract($data);

        }

        $viewPath = "app/views/$this->controllerName/$view.php";

        include_once "app/views/layout/main.php";
    }
}