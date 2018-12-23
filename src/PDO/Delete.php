<?php

    namespace App\PDO;

    class Delete implements SqlOperationsInterface
    {
        use Where, Stmt;

        private $pdo;
        private $table;
        private $validSqlParts = ['where', 'bSeparator'];
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
                }
            }
        }

        public function toSql()
        {
            $table = $this->table;
            $where = $this->buildWhere();
            return "DELETE FROM {$table} {$where}";
        }
    }