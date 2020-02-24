<?php

    namespace App\Utils;

    require_once '../../vendor/autoload.php';

    use \App\PDO\Update;
    use \App\PDO\Select;
    use \App\Render\HtmlMarkup;

    class UpdateData
    {
        use Json;

        private $table = 'users';
        private $validColumns = ['user_fullName', 'user_email', 'user_adress'];
        private $column;
        private $newValue;
        private $user_id;

        public function __construct()
        {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->data['msg'] = 'Error sending data';
            } else {
                $presenceData = Post::checkForPresenceData($_POST, ['column', 'newValue', 'user_id']);

                if (!$presenceData) {
                    $this->data['msg'] = 'Some of the necessary information empty or missing';
                } else {
                    list($column, $newValue, $user_id) = $presenceData;

                    $data = [
                        'set' => [$column => $newValue],
                        'where' => ['user_id' => $user_id]
                    ];

                    $update = new Update($this->table, $data);
                    $isChangedRows = $update->checkForUpdateFields();

                    if (!$isChangedRows) {
                        $this->data['msg'] = "The data in the table {$this->table} has not been changed";
                    } else {
                        $users = new Select($this->table, []);
                        $usersData = $users->all();
                        $this->data['markup'] = HtmlMarkup::generate('usersInfo.twig', ['usersData' => $usersData, 'orderBy' => 'user_pos']);
                        $this->data['result'] = 'success';
                    }
                }
            }
        }
    }

    $updateData =  new UpdateData();
    $updateData->echoInEncode();
