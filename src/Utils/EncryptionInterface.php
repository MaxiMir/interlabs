<?php

    namespace App\Utils;

    interface EncryptionInterface
    {
        public static function encode($ecText);

        public static function decode($decText);

    }