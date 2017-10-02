<?php
    session_start();
    if( !isset($_SESSION['LXMC_TEAM']) ){
        http_response_code(403);
        exit;
    }
    require_once './database/database.php';
    require_once './item-use-history.php';

    $deal_id = $_GET['deal-id'];
    echo $deal_id;
    $db = Database::connect();
   
    
    
    
    
    $itemUseHistory = new ItemUseHistory();
    $itemUseHistory->insert($team_id, $item_id, array($deal_id), $use_result);
    $item_id = 0; // ITEM_ID of 'Item 1' is 0
    $item_use_history_id = "'{$item_id}-{$team_id}'";
    $use_result = 0;
    $json = array('dealId'=>$deal_id, 'price'=>$use_result);
    
    header('content-type: application/json; charset=utf-8');
    echo json_encode($json);
    
    
    function sumDealPrices($db, $dealId){
		 $sql = "select deal.DEAL_ID
					  , deal.DEAL_TITLE
				      , deal.DEAL_PRICE
				   from DEAL deal
				  where deal.DEAL_ID = $deal_id";
				  
        $deal = $db->query($sql);
        $sum = 0;
        $deal_id_list = [];
        foreach($deal as $row){
            $deal_id = $row['DEAL_ID'];
            $sum += $row['DEAL_PRICE'];
            $team_id = $_SESSION['LXMC_TEAM'];
            array_push($deal_id_list, $deal_id);
        }
		$price_dif = 0;
		return array('dealIdList' => $deal_id_list, 'price' => sum);
	}
	
	function clacDiffernce($expect, $actial){
		$diff = $expect - $actual;
		return $diff;
	}
?>