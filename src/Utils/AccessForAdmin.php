<?php

    namespace App\Utils;

    require_once '../../vendor/autoload.php';

    use \App\PDO\Select;

    session_start();

    class AccessForAdmin implements UtilsInterface
    {
        use JsonDecode;

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
                    list($this->adLog, $this->adPass) = $presenceData;
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
            $hpassword = $user->one();

            if (!password_verify($this->adPass, $hpassword)) {
                $this->data['msg'] = 'Login or password entered is not correct';
                session_destroy();
            } else {
                $encText = Encryption::encode($this->adLog);
                $_SESSION['user'] = [$this->adLog, $encText];
                $this->data['result'] = 'success';
            }
        }
    }

    $accessForAdmin = new AccessForAdmin();
    $accessForAdmin->echoJsonEncode();

