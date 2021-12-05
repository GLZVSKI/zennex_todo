<?php

namespace application\core;

use application\services\Database;

class Model extends Database
{
    public $tableName;
    public $id; // Первичный ключ
}