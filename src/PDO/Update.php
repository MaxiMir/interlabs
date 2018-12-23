<?php

    namespace App\PDO;

    class Update implements SqlOperationsInterface
    {
        use Where, Stmt;

        private $pdo;
        private $table;
        private $set;
        private $newValues;
        private $validSqlParts = ['set', 'where', 'bSeparator'];
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

        private function buildSet()
        {
            $params = $this->set;
            $inData = array_reduce(array_keys($params), function($acc, $key) use ($params) {
                $value = $params[$key];

                $acc['partsSql'][] = "{$key} = ?";
                $acc['newValues'][] = $value;
                return $acc;
            }, ['partsSql' => [], 'newValues' => []]);

            $this->newValues = $inData['newValues'];
            return implode(', ', $inData['partsSql']);
        }

        public function toSql()
        {
            $table = $this->table;
            $what = $this->buildSet();
            $where = $this->buildWhere();
            return "UPDATE {$table} SET {$what} {$where}";
        }

        public function getStmt()
        {
            try {
                $stmt = $this->pdo->prepare($this->toSql());
                $values = array_merge($this->newValues, $this->inValues);
                $stmt->execute($values);
                return $stmt;
            } catch (\PDOException $e) {
                die("There`s an error in the query:<br> {$this->toSql()} <br>in file:<br>" . __FILE__);
            }
        }

        public function checkForUpdateFields()
        {
            return 0 < $this->getStmt()->rowCount();
        }
    }

