<?php
    require_once dirname(__FILE__).'/database/database.php';

    class ItemUseHistory{
        private $database;

        public function __construct(){
            $this->database = Database::connect();
        }

        public function getHistory($team_id){
            $sql = "select history.ITEM_USE_HISTORY_ID
                         , history.TEAM_ID
                         , history.ITEM_ID
                         , history.ITEM_USE_RESULT
                         , item.ITEM_NAME
                      from ITEM_USE_HISTORY history
                     inner join ITEM item on item.ITEM_ID = history.ITEM_ID
                     where history.TEAM_ID = $team_id";

            $result = $this->database->query($sql);
            $json = [];
            if( empty($result) ){
                return json_encode($json);
            }
            foreach($result as $row){
                $history_id = $row['ITEM_USE_HISTORY_ID'];
                $team_id = intval($row['TEAM_ID']);
                $item_id = intval($row['ITEM_ID']);
                $item_name = $row['ITEM_NAME'];
                $item_use_result = intval($row['ITEM_USE_RESULT']);

                $deal_id_arr = [];
                $deal_id_list = $this->database->query("select DEAL_ID from ITEM_USE where ITEM_USE_HISTORY_ID = '{$history_id}'");
                foreach($deal_id_list as $deal_id){
                    array_push($deal_id_arr, intval($deal_id['DEAL_ID']));
                }

                $arr = array('teamId'=>$team_id,'itemId'=>$item_id, 'itemName'=>$item_name, 'dealIdList'=>$deal_id_arr, 'itemUseResult' => $item_use_result );
                array_push($json, $arr);
            }

            header('content-type: application/json; charset=utf-8');
            return json_encode($json);
        }

        public function insert($quiz_no, $team_id, $item_id, $deal_id_list, $use_result){
            $history_id = "{$item_id}-{$team_id}-$quiz_";
            $sql = "insert into ITEM_USE_HISTORY(ITEM_USE_HISTORY_ID, TEAM_ID, ITEM_ID, ITEM_USE_RESULT)
                                           values('{$history_id}', {$team_id}, {$item_id}, '{$use_result}')";
            $this->database->query($sql);

            $item_use_insert_sql = "insert into ITEM_USE(DEAL_ID, ITEM_USE_HISTORY_ID) values(:deal_id, '{$history_id}')";
            $stmt = $this->database->prepare($item_use_insert_sql);
            foreach($deal_id_list as $deal_id){
                $stmt->execute(array(':deal_id'=>$deal_id));
            }
			$stmt = null;
        }
    }
?>
