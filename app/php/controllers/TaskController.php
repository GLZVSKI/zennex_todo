<?php

namespace php\controllers;

use php\core\Controller;
use php\core\Validation;
use php\core\View;
use php\models\Task;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->model = new Task();
        $this->view = new View();
        $this->json = json_decode(file_get_contents('php://input'), false);
    }

    function action_index()
    {
        $this->view->generate('task.php', $this->view->template_view);
    }

    function action_get()
    {
        $data = $this->model->get_all();

        echo json_encode(array(
            'tasks' => $data,
        ));
    }

    function action_update()
    {
        $task = $this->json->task;

        if (is_object($task)) {
            if (!Validation::empty_string($task->title)) {
                $data = $this->model->creation($task);
            }
        };

        echo json_encode(array(
            'response' => $data ?? false,
        ));
    }

    function action_delete()
    {
        $id = (int)$this->json->id;

        if (!is_numeric($id)) return false;

        $data = $this->model->remove($id);

        echo json_encode(array(
            'response' => $data,
        ));
    }

    function action_create()
    {
        $task = $this->json->task;

        if (is_object($task)) {
            if (!Validation::empty_string($task->title)) {
                $data = $this->model->creation($task);
            }
        };

        echo json_encode(array(
            'response' => $data ?? false,
        ));
    }

}
