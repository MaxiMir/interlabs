<?php

    namespace App\Utils;

    class User implements UserInterface
    {
        public static function isAdmin()
        {
            return !empty($_SESSION['user']);
        }
    }
