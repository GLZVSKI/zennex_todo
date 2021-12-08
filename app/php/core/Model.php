<?php

namespace php\core;

use php\services\Database;

class Model extends Database
{
    public $tableName;
    public $id; // Первичный ключ
}
