<?php

    namespace App\Utils;

    trait JsonDecode
    {
        private $data = [
            'msg' => '',
            'result' => 'error'
        ];

        public function echoJsonEncode()
        {
            header('Content-Type: application/json');
            echo json_encode($this->data);
        }
    }