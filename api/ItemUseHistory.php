
<?php

    require_once 'database/Database.php';
    $database = new Database();
    $teamId = $_GET['teamId'];
    $sql = "select * 
              from ITEM_USE_HISTORY history
             where history.TEAM_ID = $teamId";

    $result = $database->query($sql);
    $json = [];
    foreach($result as $row){
        $team_id = intval($row['TEAM_ID']);
        $item_id = intval($row['ITEM_ID']);
        $item_use_result = intval($row['ITEM_USE_RESULT']);

        $deal_id_arr = [];
        $deal_id_list = $database->query("select DEAL_ID from ITEM_USE where ITEM_USE_HISTORY_ID = $team_id");
        foreach($deal_id_list as $deal_id){
            array_push($deal_id_arr, intval($deal_id['DEAL_ID']));
        }
    
        $arr = array('teamId'=>$team_id,'itemId'=>$item_id, 'dealIds'=>$deal_id_arr, 'itemUseResult' => $item_use_result );
        array_push($json, $arr);
    }
    header('content-type: application/json; charset=utf-8');
    echo json_encode($json);

?>

