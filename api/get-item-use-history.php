<?php
    session_start();
    if( !isset($_SESSION['LXMC_TEAM']) ){
        header('content-type: application/json; charset=utf-8');
        echo json_encode([]);
        exit;
    }
    require_once './item-use-history.php';

    $teamId = $_SESSION['LXMC_TEAM'];
    $itemUseHistory = new ItemUseHistory();
    header('content-type: application/json; charset=utf-8');
    echo $itemUseHistory->getHistory($teamId);
?>