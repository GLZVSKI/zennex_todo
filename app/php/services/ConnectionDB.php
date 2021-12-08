<?php

namespace php\services;

class ConnectionDB
{
    private $host = 'mysql';
    private $port = '3306';
    private $user = 'user';
    private $password = 'password';
    private $dbName = 'database';

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

    public static function getInstance(): ConnectionDB
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
