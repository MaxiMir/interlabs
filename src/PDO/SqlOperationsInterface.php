<?php

    namespace App\PDO;

    interface SqlOperationsInterface
    {
        public function __construct($table, $sqlParts);

        public function toSql();
    }