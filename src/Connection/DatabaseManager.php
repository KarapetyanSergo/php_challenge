<?php

namespace App\Connection;

use PDO;

class DatabaseManager
{
    static $conn;
    public $selectSql = 'SELECT :columns FROM :tableName WHERE ';

    static function connectToDb(): PDO
    {
        if (!self::$conn) {
            $config = require 'config/env.php';
            $dbConfig = $config['db'];
            self::$conn = new PDO("mysql:host=".$dbConfig['host'].";dbname=".$dbConfig['database_name'], $dbConfig['user_name'], $dbConfig['password']);
        }

        return self::$conn;
    }

    public function getTableData(string $tableName, array $selectedColumns = null): array
    {
        $columns = $selectedColumns ? implode(',', $selectedColumns) : '*';
        $sql = "SELECT $columns FROM $tableName";

        $conn = self::connectToDb();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $conn = null;

        return $result;
    }

    public function where(string $column, string $parameter, $value): DatabaseManager
    {
        if (strlen($this->selectSql) == 38) {
            $this->selectSql = $this->selectSql."$column $parameter '$value'";
        } else {
            $this->selectSql = $this->selectSql." AND $column $parameter '$value'";
        }

        return $this;
    }

    public function getBySql(string $sql): array
    {
        $conn = self::connectToDb();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $conn = null;

        return $result;
    }

    public function get(string $tableName): array
    {
        $sql = str_replace(':tableName', $tableName, str_replace(':columns', '*', $this->selectSql));

        $conn = self::connectToDb();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $conn = null;

        return $result;
    }

    public function create(string $tableName, array $data): string
    {
        $conn = self::connectToDb();

        $columns = implode(', ', array_keys($data));
        $tokens = '?';

        for ($i=1; $i<count($data); $i++) {
            $tokens = $tokens.',?';
        }

        $sql = "INSERT INTO $tableName ($columns) VALUES ($tokens)";

        $stmt = $conn->prepare($sql);
        $stmt->execute(array_values($data));

        return $conn->lastInsertId();
    }

    public function updateById(string $tableName, array $data, int $id): array
    {
        $sql = "UPDATE $tableName";

        $i = 0;
        foreach ($data as $columnName => $value) {
            if ($i==0) {
                $sql = $sql." SET $columnName='$value'";
                $i = $i+1;
            }

            $sql = $sql.", $columnName='$value'";
        }

        $sql = $sql." WHERE id=$id";

        $conn = self::connectToDb();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $conn = null;

        return $result;
    }
}