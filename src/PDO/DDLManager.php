<?php

    namespace App\PDO;

    use App\Conf\DDLSettings;

    class DDLManager
    {
        public static function connect()
        {
            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            ];

            try {
                return new \PDO(DDLSettings::DSN, DDLSettings::DBUSER, DDLSettings::DBPASS, $options);
            } catch (\PDOException $e) {
                die('Error connecting to the database: ' . $e->getMessage());
            }
        }
    }
