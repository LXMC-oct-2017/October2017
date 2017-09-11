
<?php	

class Database{
	const CONFIG = array('user'=>'root', 'passwd'=>'');

	const DSN = 'mysql:dbname=lxmcdb;host=localhost';
	private $pdo = null;
	public function __construct(){
		try{
			$this->pdo = new PDO( Database::DSN, Database::CONFIG['user'], Database::CONFIG['passwd']);
		}catch(PDOException $e){
			echo "connection error";
			echo $e;
		}
	}

	public function query( $statment ){
		return $this->pdo->query( $statment );
	}
}

?>

