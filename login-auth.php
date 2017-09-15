<?php
	require './api/database/Database.php';
	$team_id = $_GET['team-id'];
	$passwd_hash = hash('md5', $_GET['password']);
	echo 'input: '.$passwd_hash.'<br>';

	$db = Database::connect();
	$stmt = $db->query("select PASSWORD from TEAM where TEAM_ID = $team_id");
	
	
	$correct_pw = $stmt->fetchAll(PDO::FETCH_COLUMN, 'PASSWORD');
	foreach($correct_pw as $row){
		echo 'correct: '.$row.'<br>';
	}
	if(in_array($passwd_hash, $correct_pw)){
		echo 'logged in !';
	}else{
		loginFail();
	}

	function loginFail(){
		$url = 'login.php?result=failed';
		header("Location: {$url}");
		exit;
	}
?>