<?php

namespace php\services;

include "ConnectionDB.php";

class Database
{
    private static $connect;

    public function __construct()
    {
        try {
            self::$connect = ConnectionDB::getInstance();
        } catch (\Exception $e) {
            die("Error: <pre>$e</pre>");
        }
    }

    /**
     * @param string $sql
     * @return array|false
     */
    static function request(string $sql)
    {
        $data = self::$connect->db->query($sql);
        $data->execute();

        return $data->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @return array|false
     */
    public static function all()
    {
        $className = get_called_class();
        $newClass = new $className;

        if (!isset($newClass->tableName)) return false;

        $query = "SELECT * FROM `" . $newClass->tableName . "`";
        $request = self::$connect->db->prepare($query);
        $request->execute();

        $data = $request->fetchAll(\PDO::FETCH_CLASS, get_called_class());

        foreach ($data as $row) { // Убрать имя таблицы
            unset($row->tableName);
        }

        return $data;
    }

    /**
     * @param int $id
     * @return false|mixed
     */
    static function findID(int $id)
    {
        $className = get_called_class();
        $newClass = new $className;

        if (!isset($newClass->tableName)) return false;

        $query = "SELECT * FROM `" . $newClass->tableName . "` WHERE `id` = ? LIMIT 1";
        $request = self::$connect->db->prepare($query);
        $request->execute(array($id));

        if ($request->rowCount()) {
            $row = $request->fetchObject();

            foreach ($row as $key => $value) {
                $newClass->$key = $value;
            }

            return $newClass;

        } else return false;
    }

    /**
     * @return bool
     */
    public function create(): bool
    {
        if (!is_object($this)) return false;

        $data = array_filter(get_object_vars($this), function ($element) {
            return !empty($element);
        });

        unset($data['tableName']);

        $keys = array_keys($data);
        $columns = implode(",", $keys);
        $columnsVal = implode(",:", $keys);

        $query = "INSERT INTO `{$this->tableName}` ($columns) VALUES(:$columnsVal)";
        $request = self::$connect->db->prepare($query);

        foreach ($data as $key => $value) {
            $request->bindValue(":$key", $value);
        }

        return $request->execute();
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        if (!is_object($this)) return false;

        $data = array_filter(get_object_vars($this), function ($element) {
            return !is_null($element);
        });

        unset($data['id']);
        unset($data['tableName']);

        if (empty($data)) return false;

        $columns = "";

        foreach ($data as $key => $value) {
            $columns .= "`$key` = :$key, ";
        }

        $columns = substr($columns, 0, -2);

        $query = "UPDATE `{$this->tableName}` SET {$columns} WHERE `id` = :id";
        $request = self::$connect->db->prepare($query);
        $request->bindValue(":id", $this->id);

        foreach ($data as $key => $value) {
            $request->bindValue(":$key", $value);
        }

        return $request->execute();
    }

    /**
     * @param $obj
     * @return false|int
     */
    static function delete($obj)
    {
        if (!is_object($obj)) return false;

        $id = $obj->id;

        if (!empty($id)) {
            $query = "DELETE FROM `" . $obj->tableName . "` WHERE `id` = ? LIMIT 1";
            $request = self::$connect->db->prepare($query);
            $request->execute(array($id));

            return $request->rowCount();

        } else return false;
    }
}
