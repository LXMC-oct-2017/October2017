<?php
    session_start();
    if( !isset($_SESSION['LXMC_TEAM']) ){
        // not logged in
        $login_url = '../login/login.php';
        header("Location: $login_url");
    }

    require_once 'database/database.php';
    $database = Database::connect();
    $teamId = $_SESSION['LXMC_TEAM'];
    $sql = "select history.TEAM_ID 
                 , history.ITEM_ID
                 , history.ITEM_USE_RESULT
                 , item.ITEM_NAME
              from ITEM_USE_HISTORY history
                inner join ITEM item on item.ITEM_ID = history.ITEM_ID
             where history.TEAM_ID = $teamId";

    $result = $database->query($sql);
    $json = [];
    foreach($result as $row){
        $team_id = intval($row['TEAM_ID']);
        $item_id = intval($row['ITEM_ID']);
        $item_name = $row['ITEM_NAME'];
        $item_use_result = intval($row['ITEM_USE_RESULT']);

        $deal_id_arr = [];
        $deal_id_list = $database->query("select DEAL_ID from ITEM_USE where ITEM_USE_HISTORY_ID = $team_id");
        foreach($deal_id_list as $deal_id){
            array_push($deal_id_arr, intval($deal_id['DEAL_ID']));
        }
    
        $arr = array('teamId'=>$team_id,'itemName'=>$item_name, 'dealIds'=>$deal_id_arr, 'itemUseResult' => $item_use_result );
        array_push($json, $arr);
    }
    header('content-type: application/json; charset=utf-8');
    echo json_encode($json);

?>