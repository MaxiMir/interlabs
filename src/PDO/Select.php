<?php

namespace App\PDO;

class Select implements SelectInterface
{
    use Where, Stmt;

    private $pdo;
    private $table;
    private $validSqlParts = ['select', 'where', 'orderBy', 'bSeparator', 'limit', 'maxValue'];
    private $select = '*';
    private $orderBy;
    private $limit;
    private $maxValue;

    public function __construct($table, $sqlParts = [])
    {
        $this->pdo = DDLManager::connect();
        $this->table = $table;

        foreach ($sqlParts as $nameSqlPart => $valSqlPart) {
            if (in_array($nameSqlPart, $this->validSqlParts)) {
                $this->$nameSqlPart = $valSqlPart;
            }
        }
    }

    private function buildSelect()
    {
        if (is_array($this->select)) {
            $this->select = implode(', ', $this->select);
        }
        return ($this->maxValue == "Y") ? "SELECT MAX({$this->select})": "SELECT {$this->select}";
    }

    private function buildFrom()
    {
        return "FROM {$this->table}";
    }

    private function buildOrderBy()
    {
        if (empty($this->orderBy)) {
            return '';
        } elseif ($this->orderBy == 'user_pos') {
            return "ORDER BY {$this->orderBy}";
        }
        return "ORDER BY BINARY(lower({$this->orderBy}))";
    }

    private function buildLimit()
    {
        if (empty($this->limit)) {
            return '';
        }
        $limit = is_array($this->limit) ? implode(', ', $this->limit) : $this->limit;
        return "LIMIT {$limit}";
    }

    public function toSql()
    {
        $sqlParts = [];
        $sqlParts[] = $this->buildSelect();
        $sqlParts[] = $this->buildFrom();
        $sqlParts[] = $this->buildWhere();
        $sqlParts[] = $this->buildOrderBy();
        $sqlParts[] = $this->buildLimit();

        return implode(' ', array_filter($sqlParts, function ($sqlPart) {
            return !empty($sqlPart);
        }));
    }

    public function one()
    {
        return $this->getStmt()->fetchColumn();
    }

    public function all()
    {
        return $this->getStmt()->fetchAll();
    }
}