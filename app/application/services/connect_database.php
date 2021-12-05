<?php

namespace application\services;

class Connect
{
    use settings_db;

    public $db;
    private static $instances;

    protected function __construct()
    {
        try {
            $this->db = new \PDO("mysql:host=$this->host; port=$this->port; dbname=$this->dbName", $this->user, $this->password);
        } catch (\PDOException $e) {
            die("Error DB: <pre>$e</pre>");
        }
    }

    public static function getInstance(): Connect
    {
        $cls = static::class;
        if (!isset(self::$instances)) {
            self::$instances = new static();
        }

        return self::$instances;
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
    }
}