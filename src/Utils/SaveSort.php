<?php

    namespace App\Utils;

    require_once '../../vendor/autoload.php';

    use \App\PDO\Update;

    class SaveSort
    {
        use Json;

        private $table = 'users';
        private $validColumns = ['ids'];

        public function __construct()
        {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->data['msg'] = 'Error sending data';
            } else {
                $presenceData = Post::checkForPresenceData($_POST, ['ids']);

                if (!$presenceData) {
                    $this->data['msg'] = 'Some of the necessary information empty or missing';
                } else {
                    $countChangeRows = 0;
                    list($ids) = $presenceData;

                    foreach ($ids as $user_pos => $user_id) {
                        $data = [
                            'set' => ['user_pos' => $user_pos + 1],
                            'where' => ['user_id' => $user_id]
                        ];

                        $update = new Update($this->table, $data);
                        $isChangedRows = $update->checkForUpdateFields();

                        if ($isChangedRows) {
                            $countChangeRows++;
                        }
                    }

                    if ($countChangeRows > 0) {
                        $this->data['result'] = 'success';
                    } else {
                        $this->data['msg'] = "The data in the table {$this->table} has not been changed";
                    }
                }
            }
        }
    }

    $saveSort =  new SaveSort();
    $saveSort->echoInEncode();
