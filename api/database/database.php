<?php
require_once dirname(__FILE__).'・/../config.php';

class Database{
    public static function connect(){
        $config = Config::getInstance();
        $db_config = $config->getConfig('database');
        $scheme = $db_config['scheme'];
        $host_name = $db_config['host_name'];
        $db_name = $db_config['db_name'];
        $user = $db_config['user'];
        $passwd = $db_config['password'];
        $dsn = "{$scheme}:dbname={$db_name};host={$host_name}; charset=utf8mb4";
        
        try{
            $pdo = new PDO($dsn, $user, $passwd);
            return $pdo;
        }catch(PDOException $e){
            echo "connection error";
            echo $e;
        }
    }
}
?>
