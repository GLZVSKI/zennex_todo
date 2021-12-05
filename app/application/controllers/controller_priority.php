<?php

namespace application\controllers;

use application\core\Controller;
use application\models\Model_priority;

class Controller_priority extends Controller
{
    function __construct()
    {
        $this->model = new Model_priority();
    }

    function action_get()
    {
        $data = $this->model->get_all();

        echo json_encode(array(
            'priority' => $data,
        ));
    }
}