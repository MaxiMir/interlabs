<?php

    namespace App\Utils;

    require_once '../../vendor/autoload.php';

    use \App\PDO\Select;

    session_start();

    class AccessForAdmin
    {
        use Json;

        private $adLog;
        private $adPass;

        public function __construct()
        {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->data['msg'] = 'Error sending data';
            } else {
                $presenceData = Post::checkForPresenceData($_POST, ['adLog', 'adPass']);

                if (!$presenceData) {
                    $this->data['msg'] = 'Some fields of the form are not available or empty';
                } else {
                    [$this->adLog, $this->adPass] = $presenceData;
                    $this->verifyUser();
                }
            }
        }
        
        private function verifyUser()
        {
            $user = new Select('admins', [
                'select' => 'ad_pass',
                'where' => ['ad_log' => $this->adLog]
            ]);
            
            $hashPassword = $user->one();
            
            if (!password_verify($this->adPass, $hashPassword)) {
                $this->data['msg'] = 'Login or password entered is not correct';
                session_destroy();
            } else {
                $_SESSION['user'] = time();
                $this->data['result'] = 'success';
            }
        }
    }

    $accessForAdmin = new AccessForAdmin();
    $accessForAdmin->echoInEncode();

