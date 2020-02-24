<?php

    namespace App\Utils;

    require_once '../../vendor/autoload.php';

    use \App\PDO\Delete;
    use \App\PDO\Select;
    use \App\Render\HtmlMarkup;

    class DeleteData
    {
        use Json;

        private $table = 'users';

        public function __construct()
        {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->data['msg'] = 'Error sending data';
            } else {
                $presenceData = Post::checkForPresenceData($_POST, ['ids']);

                if (!$presenceData) {
                    $this->data['msg'] = 'Some of the necessary information empty or missing';
                } else {
                    list($ids) = $presenceData;

                    $data = ['where' => ['user_id' => $ids]];
                    $delete = new Delete($this->table, $data);
                    $isChangedRows = $delete->checkForUpdateFields();

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

    $deleteData =  new DeleteData();
    $deleteData->echoInEncode();