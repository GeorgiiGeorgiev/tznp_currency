<?php

class DB
{
    private $DB_HOST = '';

    private $DB_NAME = '';

    private $DB_USER = '';

    private $DB_PASS = '';

    private $connection;

    private static $instance = null;

    private function __clone(){}

    private function __wakeup(){}

    private function __construct()
    {
        try {

            // цепляем подключение к бд
            $dbConfigs = parse_ini_file('app/configs/db.ini');

            $this->connection = new PDO(
                'mysql:host=' . $dbConfigs['db_host'] . ';dbname=' .$dbConfigs['db_name'],
                $dbConfigs['db_user'],
                $dbConfigs['db_password'],

                [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]
            );

        } catch (PDOException $e) {

            echo $e->getMessage();

        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public static function getInstance()
    {

        if (is_null(self::$instance)) {

            self::$instance = new self();

        }

        return self::$instance;

    }
}