<?php
	require_once dirname(__FILE__).'/auth-util.php';
	AuthUtil::forbiddenIfNotAuthorized();
	
    require_once dirname(__FILE__).'/database/database.php';
    require_once dirname(__FILE__).'/item-use-history.php';
	require_once dirname(__FILE__).'/team-status.php';
	require_once dirname(__FILE__).'/database/query.php';
	require_once dirname(__FILE__).'/config.php';
	
	if( TeamStatus::isUsedItem2($_SESSION['LXMC_TEAM']) ){
		http_response_code(400);
		$messages = array('アイテム2はすでに使用済みです');
		echo json_encode(['messages' => $messages]);
	}else{
		useItem();
	}
	
	function useItem(){
		$config = Config::getInstance()->getConfig('general');
		$target_money = $config['target_money'];
		
		$deal_id_list = $_GET['dealIdList'];
		$sum = sumDealPrices($deal_id_list);
		$use_result = roundDiffernce($target_money, $sum);

		$history = new ItemUseHistory();
		$history->insert($_SESSION['LXMC_TEAM'], 1, $deal_id_list, $use_result);
		TeamStatus::useItem2($_SESSION['LXMC_TEAM']);

		echo json_encode(array('dealIds'=> $deal_id_list, 'useResult'=>$use_result));
	}
	
    /**
	 * 配列で渡されたディールの価格の合計を計算する
	 * @param string deal_id_list ディールIDのリスト $_GET からそのまま渡す
	 * @return int 合計金額
	 */
    function sumDealPrices($deal_id_list){
		$db = Database::connect();
		$sql = "select deal.DEAL_ID
					 , deal.DEAL_TITLE
				     , deal.DEAL_PRICE
				  from DEAL deal
				 where deal.DEAL_ID ";
        $deal = $db->query($sql.QueryUtil::whereIn($deal_id_list));
        $sum = 0;
        foreach($deal as $row){
            $deal_id = $row['DEAL_ID'];
            $sum += $row['DEAL_PRICE'];
        }
		$price_dif = 0;
		return $sum;
	}

	/**
	 * 金額の差分を5000円単位に丸める
	 * @param int $expect 目標金額
	 * @param int $actual 合計金額
	 * @return string 差分を5000円単位で丸めた結果のメッセージ
	 */
	function roundDiffernce($expect, $actual){
		$result_plus = ['0~4999円','5000~9999円','10000円~14999円','15000円~19999円','20000円以上'];
		$result_minus = ['0~-4999円','-5000~-9999円','-10000円~-14999円','-15000円~-19999円','-20000円以上'];
		$diff = $expect - $actual;
		if( $diff == 0 ){
			return '差分なし';
		}
		$index = min(intval(abs($diff)/5000), count($result_plus)-1);
		return $diff > 0 ? $result_minus[$index] : $result_plus[$index];
	}
?>
