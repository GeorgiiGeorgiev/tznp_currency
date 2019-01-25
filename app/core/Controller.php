<?php

abstract class Controller
{
    public $view;

    public function __construct()
    {
        $this->view = new View(static::class);
    }

    public function actionIndex(){}
}