<?php
	require_once dirname(__FILE__).'/auth-util.php';
	AuthUtil::forbiddenIfNotAuthorized();
	
    require_once dirname(__FILE__).'/database/database.php';
    require_once dirname(__FILE__).'/item-use-history.php';
	require_once dirname(__FILE__).'/team-status.php';
	
	header('content-type: application/json; charset=utf-8');
	
	if( TeamStatus::isUsedItem1($_SESSION['LXMC_TEAM']) ){
		http_response_code(400);
		$messages = array('アイテム1はすでに使用済みです');
		echo json_encode(['messages' => $messages]);
	}else{
		useItem();
	}
	
	
	function useItem(){
		 $deal_id = $_GET['dealId'];
		$db = Database::connect();
		$sql = "select deal.DEAL_ID
					 , deal.DEAL_TITLE
					 , deal.DEAL_PRICE
				  from DEAL deal
				 where deal.DEAL_ID = $deal_id";
		$deal = $db->query($sql);
		$row = $deal->fetch();
		$deal_id = $row['DEAL_ID'];
		$deal_title = $row['DEAL_TITLE'];
		$use_result = $row['DEAL_PRICE'];
		$team_id = $_SESSION['LXMC_TEAM'];
		$item_id = 0; // ITEM_ID of 'Item 1' is 0
		$item_use_history_id = "'{$item_id}-{$team_id}'";

		$json = array('dealId'=>$deal_id, 'dealTitle'=>$deal_title, 'dealPrice'=>$use_result);

		$itemUseHistory = new ItemUseHistory();
		$itemUseHistory->insert($team_id, $item_id, array($deal_id), $use_result);
		
		TeamStatus::useItem1($_SESSION['LXMC_TEAM']);
		
		echo json_encode($json);
	}
?>
