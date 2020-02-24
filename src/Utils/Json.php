<?php

    namespace App\Utils;

    trait Json
    {
        private $data = [
            'msg' => '',
            'result' => 'error'
        ];

        public function echoInEncode()
        {
            header('Content-Type: application/json');
            echo json_encode($this->data);
        }
    }