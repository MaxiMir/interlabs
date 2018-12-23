<?php

    namespace App\PDO;

    interface SelectInterface extends SqlOperationsInterface
    {
        public function one();

        public function all();
    }
