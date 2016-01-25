<?php
namespace components;

use PDO;
use components\Config as Config;

class Db
{
    public static function getConnection()
    {
        $db_params = Config::getDbParams();

        $dsn = "mysql:host={$db_params['host']};dbname={$db_params['db_name']}";
        $db = new PDO($dsn, $db_params['user'], $db_params['password']);

        return $db;
    }
}
