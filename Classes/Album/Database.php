<?php
namespace Album;
define('SQLITE_DB', __DIR__.'/../../Data/Music.sqlite');

use PDO;
class Database{
    private static $pdo;

    public static function getPdo(){
        if (self::$pdo === null){
            self::$pdo = new PDO('sqlite:' . SQLITE_DB);
        }
        return self::$pdo;
    }
}
?>