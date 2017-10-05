<?php
	require_once dirname(__FILE__).'/database/database.php';
	require_once dirname(__FILE__).'/database/query.php';
	
	function registerAnswer($team_id, $answer_price, $deal_id_list){
		$answer_id = "ANS-{$team_id}";
		$answer_sql = "insert into ANSWER(ANSWER_ID, TEAM_ID, ANSWER_PRICE, ANSWER_DATETIME)
		                            value('{$answer_id}', {$team_id}, {$answer_price}, now())";

		$db = Database::connect();
		$db->query($answer_sql);
		
		$answer_detail_sql = "insert into ANSWER_DETAIL(ANSWER_ID, DEAL_ID) value('{$answer_id}', :deal_id)";
		$stmt = $db->prepare($answer_detail_sql);
		foreach($deal_id_list as $deal_id){
			$stmt->execute(array(':deal_id'=>$deal_id));
		}
		
		$db = null;
		$stmt = null;
	}
?>