<?php

    namespace App\Utils;

    class Admin implements AdminInterface
    {
        public static function checkOnAdmin()
        {
            if (!isset($_SESSION['user'])) {
                return false;
            } else {
                list($adLog, $encText) = $_SESSION['user'];
                $decodeText = Encryption::decode($encText);
                return $adLog == $decodeText;
            }
        }
    }
