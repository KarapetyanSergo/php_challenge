<?php

namespace App\Tables;

use App\Connection\DatabaseManager;
use App\Tables\Users\User;

abstract class Table
{
    public $selectSql = 'SELECT :columns FROM :tableName';
    public array $data;

    public function getAll(): array
    {
        $db = new DatabaseManager();

        return $db->getTableData($this->table, $this->columns);
    }

    public function getById(int $id): ?User
    {
        $db = new DatabaseManager();

        $result =$db->where('id', '=', $id)->get($this->table);
        if (!isset($result[0])) return null;

        return new User($result[0]);
    }

    public function create(array $data): User
    {
        $id = (new DatabaseManager())->create($this->table, [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'birth_date' => $data['birth_date'],
            'image' => $data['image'] ?? null,
        ]);

        return $this->getById($id);
    } 

    public function where(string $column, string $parameter, $value)
    {
        if (strlen($this->selectSql) == 31) {
            $this->selectSql = $this->selectSql."  WHERE $column $parameter '$value'";
        } else {
            $this->selectSql = $this->selectSql." AND $column $parameter '$value'";
        }

        return $this;
    }

    public function updateById(array $data, int $id): User
    {
        $db = new DatabaseManager();
        $db->updateById($this->table, $data, $id);

        return $this->getById($id);
    }

    public function get(array $selectedColumns = null)
    {
        $columns = $selectedColumns ? implode(',', $selectedColumns) : '*';
        $sql = str_replace(':tableName', $this->table, str_replace(':columns', $columns, $this->selectSql));

        $db = new DatabaseManager();
        $this->data = $db->getBySql($sql);

        return $this;
    }

    public function first(): ?User
    {
        if (!isset($this->data[0])) return null;

        return new User($this->data[0]);
    }

    public function toArray(): array
    {
        return $this->data;
    }
}