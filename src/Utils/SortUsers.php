<?php

    namespace App\Utils;

    require_once '../../vendor/autoload.php';

    use \App\PDO\Select;
    use \App\Render\HtmlMarkup;

    class SortUsers
    {
        use Json;

        private $table = 'users';

        public function __construct()
        {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->data['msg'] = 'Error sending data';
            } else {
                $presenceData = Post::checkForPresenceData($_POST, ['orderBy']);

                if (!$presenceData) {
                    $this->data['msg'] = 'Some of the necessary information empty or missing';
                } else {
                    list($orderBy) = $presenceData;

                    $users = new Select($this->table, ['orderBy' => $orderBy]);
                    $usersData = $users->all();
                    $this->data['markup'] = HtmlMarkup::generate('usersInfo.twig', ['usersData' => $usersData]);
                    $this->data['result'] = 'success';
                }
            }
        }
    }

    $sortUsers =  new SortUsers();
    $sortUsers->echoInEncode();