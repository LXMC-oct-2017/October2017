<?php
    session_start();
    if( !isset($_SESSION['LXMC_TEAM']) ){
        http_response_code(403);
        exit;
    }

    require_once 'database/database.php';
    $db = Database::connect();
    $deal_list = $db->query('select * from DEAL');
    $json = [];
    foreach( $deal_list as $deal ){
        $deal_id = $deal['DEAL_ID'];
        $deal_title = $deal['DEAL_TITLE'];
        array_push($json, array('dealId'=>$deal_id, 'dealTitle'=>$deal_title));
    }
    header('content-type: application/json; charset=utf-8');
    echo json_encode($json);
?>
