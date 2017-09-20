<?php
    require_once 'database/database.php';

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
            
                $arr = array('teamId'=>$team_id,'itemName'=>$item_name, 'dealIdList'=>$deal_id_arr, 'itemUseResult' => $item_use_result );
                array_push($json, $arr);
            }
            return json_encode($json);
        }

		public function insert($team_id, $item_id, $deal_id_arr){
			$sql = 'insert into ITEM_USE_HISTORY( ITEM_USE_HISTORY_ID, TEAM_ID, ITEM_ID, )';
		}
    }
?>