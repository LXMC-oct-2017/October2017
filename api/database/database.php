<?php
require_once dirname(__FILE__).'・/../config.php';

class Database{
    const CONFIG = array('user'=>'root', 'passwd'=>'');

    const DSN = 'mysql:dbname=lxmcdb;host=localhost';
	
    public static function connect(){
		$config = Config::getInstance();
		$db_config = $config->getConfig('database');
		$scheme = $db_config['scheme'];
		$host_name = $db_config['host_name'];
		$db_name = $db_config['db_name'];
		$user = $db_config['user'];
		$passwd = $db_config['password'];
		$dsn = "{$scheme}:dbname={$db_name};host={$host_name}";
        try{
            // $pdo = new PDO( Database::DSN, Database::CONFIG['user'], Database::CONFIG['passwd']);
			$pdo = new PDO($dsn, $user, $passwd);
            return $pdo;
        }catch(PDOException $e){
            echo "connection error";
            echo $e;
        }
    }
}

Database::connect();
?>
