<?php
	session_start();
	if( !isset($_SESSION['LXMC_TEAM']) ){
		http_response_code(403);
		exit;
	}
	require_once 'database/database.php';
	
	$deal_id_str = '';
	$deal_id_list = [];
	foreach( $_GET['dealIdList'] as $deal_id ){
		if( strlen($deal_id_str) != 0 ){
			$deal_id_str .= ', ';
		}
		$deal_id_str .= $deal_id;
		array_push( $deal_id_list, intval($deal_id) );
	}
	echo $deal_id_str;
	
	$db = Database::connect();
	$result = $db->query("select * from deal where DEAL_ID in($deal_id_str)");
	$sum = 0;
	foreach( $result as $row ){
		$sum += $row['DEAL_PRICE'];
	}
	$team_id = $_SESSION['LXMC_TEAM'];
	$db->query("update TEAM set ANSWER_STATUS_CD = 'ANS' where TEAM_ID = $team_id");
	
	header('content-type: application/json; charset=utf-8');
	echo json_encode(array('sum'=>$sum, 'dealIdList'=>$deal_id_list));
?>