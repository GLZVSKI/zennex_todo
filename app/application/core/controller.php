<?php

namespace application\core;

class Controller
{
    public $model;
    public $view;
    public $json;

    function __construct()
    {
        $this->view = new View();
        $this->json = json_decode(file_get_contents('php://input'), false);
    }

    function action_index()
    {

    }
}