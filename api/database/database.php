<?php   

class Database{
    const CONFIG = array('user'=>'root', 'passwd'=>'');

    const DSN = 'mysql:dbname=lxmcdb;host=localhost';

    public static function connect(){
        try{
            $pdo = new PDO( Database::DSN, Database::CONFIG['user'], Database::CONFIG['passwd']);
            return $pdo;
        }catch(PDOException $e){
            echo "connection error";
            echo $e;
        }
    }
}

?>