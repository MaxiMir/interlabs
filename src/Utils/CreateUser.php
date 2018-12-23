<?php

    namespace App\Utils;

    require_once '../../vendor/autoload.php';

    use \App\PDO\Insert;
    use \App\PDO\Select;
    use \App\Render\HtmlMarkup;

    class CreateUser implements UtilsInterface
    {
        use JsonDecode;

        private $table = 'users';

        public function __construct()
        {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->data['msg'] = 'Error sending data';
            } else {
                $presenceData = Post::checkForPresenceData($_POST, ['user_fullName', 'user_email', 'user_adress']);

                if (!$presenceData) {
                    $this->data['msg'] = 'Some of the necessary information empty or missing';
                } else {
                    list($user_fullName, $user_email, $user_adress) = $presenceData;

                    $getMaxValue = new Select($this->table, [
                            'select' => 'user_pos',
                            'maxValue' => 'Y'
                    ]);
                    $user_pos = $getMaxValue->one() + 1;
							
                    $data = [
                        'where' => ['user_fullName', 'user_email', 'user_adress', 'user_pos'],
                        'inValues' => [$user_fullName, $user_email, $user_adress, $user_pos]
                    ];

                    $insert = new Insert($this->table, $data);
                    $isChangedRows = $insert->checkForUpdateFields();

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

    $createUser =  new CreateUser();
    $createUser->echoJsonEncode();