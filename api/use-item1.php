<?php
  session_start();
    require 'database/database.php';
    $deal_id = $_GET['dealId'];
    $db = Database::connect();
    $sql = "select deal.DEAL_ID
                 , deal.DEAL_TITLE
                 , deal.DEAL_PRICE
              from DEAL deal
             where deal.DEAL_ID = $deal_id";
    $deal = $db->query($sql);
    foreach($deal as $row){
        $deal_id = $row['DEAL_ID'];
        $use_result = $row['DEAL_PRICE'];
        $team_id = $_SESSION['LXMC_TEAM'];
        $item_id = 0; // ITEM_ID of 'Item 1' is 0
        $item_use_history_id = $team_id.'-'.$item_id;

        $json = array('dealId'=>$deal_id, 'price'=>$use_result);
        $insert_sql = 'insert into ITEM_USE_HISTORY(ITEM_USE_HISTORY_ID, TEAM_ID, ITEM_ID, USE_RESULT) ';
		$insert_value = "value($item_use_history_id, $team_id, $item_id, $use_result)";
		$db->query($insert_sql.$insert_value);
    }

    header('content-type: application/json; charset=utf-8');
    echo json_encode($json);
?>
