<?php
    session_start();
    if( !isset($_SESSION['LXMC_TEAM']) ){
		http_response_code(403);
        exit;
    }
    require_once './item-use-history.php';

    $teamId = $_SESSION['LXMC_TEAM'];
    $itemUseHistory = new ItemUseHistory();
    header('content-type: application/json; charset=utf-8');
    echo $itemUseHistory->getHistory($teamId);
?>