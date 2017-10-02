<?php
    session_start();
    if( !isset($_SESSION['LXMC_TEAM']) ){
        http_response_code(403);
        exit;
    }
    require_once './database/database.php';
    require_once './item-use-history.php';

    $deal_id = $_GET['deal-id'];
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
        $item_use_history_id = "'{$item_id}-{$team_id}'";

        $json = array('dealId'=>$deal_id, 'price'=>$use_result);
        
        $itemUseHistory = new ItemUseHistory();
        $itemUseHistory->insert($team_id, $item_id, array($deal_id), $use_result);
    }

    header('content-type: application/json; charset=utf-8');
    echo json_encode($json);
?>