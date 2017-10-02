<html>
<head>
	<meta charset='utf-8'>
</head>
<body>
<?php
	require 'database.php';
	$db = Database::connect();
	$sql = "update TEAM
			set PASSWORD = :passwd_hash
			where TEAM_ID = :team_id";

	for( $i=0; $i<20; $i++ ){
		$team_no = $i + 1;

		$passwd_hash = hash('md5', "lxmct{$team_no}");
		$stmt = $db->prepare($sql);
		$params = array(':passwd_hash'=>$passwd_hash, ':team_id'=>$i);
		$stmt->execute($params);
	}
	$res = $db->query('select * from TEAM');
	foreach($res as $row){
		echo $row['TEAM_ID'].'   '.$row['TEAM_NAME'].'   '.$row['PASSWORD'].'<br>';
	}
?>

</body>
</html>
