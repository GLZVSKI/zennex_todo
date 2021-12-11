<?php

namespace php\models;

use php\core\Model;

class Priority extends Model
{
    public $tableName = 'priorities';
    public $title;
    public $importance;

    function get_all()
    {
        return self::all();
    }
}
