<?php

    namespace App\PDO;

    trait Stmt
    {
        private function getStmt()
        {
            try {
                if(empty($this->where)) {
                    $stmt = $this->pdo->query($this->toSql());
                } else {
                    $stmt = $this->pdo->prepare($this->toSql());
                    $stmt->execute($this->inValues);
                }
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