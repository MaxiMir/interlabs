<?php

    namespace App\PDO;

    class Insert implements SqlOperationsInterface
    {
        use Stmt;

        private $pdo;
        private $table;
        private $where;
        private $inValues;
        private $validSqlParts = ['inValues', 'where'];
        private $data = [
            'msg' => '',
            'result' => 'error'
        ];

        public function __construct($table, $sqlParts)
        {
            $this->pdo = DDLManager::connect();
            $this->table = $table;

            foreach ($sqlParts as $nameSqlPart => $valSqlPart) {
                if (in_array($nameSqlPart, $this->validSqlParts)) {
                    $this->$nameSqlPart = $valSqlPart;
                } else {
                    die("Not valid SQL part: {$nameSqlPart}");
                }
            }
        }

        private function buildColumns()
        {
            return implode(', ', $this->where);
        }

        private function buildPlaceholders()
        {
            return implode(', ', array_fill(0, count($this->inValues), '?'));
        }

        public function toSql()
        {
            $table = $this->table;
            $columns = $this->buildColumns();
            $placeholders = $this->buildPlaceholders();
            return "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        }
    }


