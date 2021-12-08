<?php

namespace php\controllers;

use php\core\Controller;
use php\models\Model_priority;

class PriorityController extends Controller
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
