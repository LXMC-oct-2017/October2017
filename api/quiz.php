<?php
	require_once dirname(__FILE__).'/auth-util.php';
    AuthUtil::forbiddenIfNotAuthorized();
	
	$quiz_no = $_GET['quizNo'];
	$answer = $_GET['ans'];
	
    require_once dirname(__FILE__).'/database/database.php';
	$db = Database::connect();
	$res = $db->query("select * from QUIZ where QUIZ_ID = $quiz_no");
	$flag = false;
	foreach( $res as $row ){
		$flag = $row['ANSWER'] == md5($answer);
	}
	
	$db = null;
	$res = null;
	
	header('content-type: application/json; charset=utf-8');
	echo json_encode(array('quizNo'=>$quiz_no, 'flag'=>$flag));
?>