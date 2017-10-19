<?php
    require_once dirname(__FILE__).'/auth-util.php';
    AuthUtil::forbiddenIfNotAuthorized();

    require_once dirname(__FILE__).'/database/database.php';
    require_once dirname(__FILE__).'/item-use-history.php';
    require_once dirname(__FILE__).'/team-status.php';

    header('content-type: application/json; charset=utf-8');
    
    $quiz_no = $_GET['quizNo'];
    
    if( TeamStatus::isUsedItem1($_SESSION['LXMC_TEAM']) ){
        $messages = array('アイテム1はすでに使用済みです');
        echoClientError($messages);
    }else if(TeamStatus::isUsedItem1WithQuiz($_SESSION['LXMC_TEAM'], $quiz_no) ){
        $disp_quiz_no = $quiz_no + 1;
        $messages = array("クイズ{$disp_quiz_no}はすでに回答済みです");
        echoClientError($messages);
    }else{
        useItem();
    }
    
    function echoClientError($messages){
        http_response_code(400);
        echo json_encode(['messages' => $messages]);
    }
    
    function useItem(){
        $deal_id = $_GET['dealId'];
        $quiz_no = $_GET['quizNo'];
        $db = Database::connect();
        $sql = "select deal.DEAL_ID
                     , deal.DEAL_TITLE
                     , deal.DEAL_PRICE
                     , deal.NO
                  from DEAL deal
                 where deal.DEAL_ID = $deal_id";
        $deal = $db->query($sql);
        $row = $deal->fetch();
        $deal_id = $row['DEAL_ID'];
        $deal_title = $row['DEAL_TITLE'];
        $use_result = $row['DEAL_PRICE'].'円';
        $use_no = $row['NO'];
        $team_id = $_SESSION['LXMC_TEAM'];
        $item_id = 0; // ITEM_ID of 'Item 1' is 0
        $item_use_history_id = "'{$item_id}-{$team_id}'";

        $json = array('dealId'=>$deal_id, 'dealTitle'=>$deal_title, 'dealPrice'=>$use_result, 'no'=>$use_no);

        $itemUseHistory = new ItemUseHistory();
        $itemUseHistory->insert($team_id, $item_id, array($deal_id), $use_result);
        
        TeamStatus::useItem1($_SESSION['LXMC_TEAM'], $quiz_no);
        
        $db = null;
        $deal = null;

        echo json_encode($json);
    }
?>
