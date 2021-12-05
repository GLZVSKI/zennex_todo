<?php

namespace application\models;

use application\core\Model;

class Model_task extends Model
{
    public $tableName = 'tasks';
    public $title;
    public $priority;
    public $status;

    public function get_all()
    {
        $data = self::request("SELECT tasks.*, priorities.title as priorityTitle
                                        FROM tasks 
                                            INNER JOIN priorities 
                                                ON (tasks.priority = priorities.id)");

        foreach ($data as $row) { // Убрать не нужные данные
            unset($row->tableName);
        }

        return $data;
    }

    public function update(object $task): bool
    {
        $this->id = $task->id;
        $this->status = $task->status;
        $this->title = $task->title;
        $this->priority = $task->priority;
        return $this->save();
    }

    public function remove(int $id)
    {
        return self::delete(self::findID($id));
    }

    public function creation(object $task)
    {
        $model = new Model_task();
        $model->title = $task->title;
        $model->priority = $task->priority;
        return $model->create();
    }

}