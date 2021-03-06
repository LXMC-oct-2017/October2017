<?php
	require_once dirname(__FILE__).'/database/database.php';
	
	class TeamStatus{
		
		const STATUS_FLG_BIT_ITEM1_QUIZ1 = 1;
		const STATUS_FLG_BIT_ITEM1_QUIZ2 = 2;
		const STATUS_FLG_BIT_ITEM1_QUIZ3 = 4;
		const STATUS_FLG_BIT_ITEM1_QUIZ4 = 8;
		const STATUS_FLG_BIT_QUIZ = [1,2,4,8];
		const STATUS_FLG_BIT_ITEM_2 = 32;
		
		const STATUS_FLG_BIT_ANSWER = 128;
		
		/**
		 * 引数で渡されたIDで識別されるチームの現在のステータスを取得
		 * @param int team_id 
		 */
		public static function getStatus($team_id){
			$db = Database::connect();
			$result = $db->query("select STATUS from TEAM where TEAM_ID = $team_id")->fetch();
			$db = null;
			return $result['STATUS'];
		}
		
		/**
		 * チームのステータスフラグにアイテム1使用済みフラグを追加して更新
		 * @param int team_id 
		 */
		public static function useItem1($team_id, $quizNo){
			$current_status = TeamStatus::getStatus($team_id);
			$flg_bit = TeamStatus::STATUS_FLG_BIT_QUIZ[$quizNo];
			TeamStatus::doUpdateStatus($team_id,  ($current_status | $flg_bit));
		}
		
		/**
		 * チームのステータスフラグにアイテム2使用済みフラグを追加して更新
		 * @param int team_id 
		 */
		public static function useItem2($team_id){
			$current_status = TeamStatus::getStatus($team_id);
			TeamStatus::doUpdateStatus($team_id, ($current_status | TeamStatus::STATUS_FLG_BIT_ITEM_2));
		}
		
		/**
		 * チームのステータスフラグに回答送信済みフラグを追加して更新
		 * @param int team_id 
		 */
		public static function sendAnswer($team_id){
			$current_status = TeamStatus::getStatus($team_id);
			TeamStatus::doUpdateStatus($team_id, ($current_status | TeamStatus::STATUS_FLG_BIT_ANSWER));
		}
		
		/**
		 * チームがアイテム1使用済みかチェックする
		 * @param int team_id 
		 */
		public static function isUsedItem1($team_id){
			for($i = 0; $i<4; ++$i){
				if( !TeamStatus::isUsedItem1WithQuiz($team_id, $i) ){
					return false;
				}
			}
			return true;
		}
		
		public static function isUsedItem1WithQuiz($team_id, $quiz_no){
			$current_status = TeamStatus::getStatus($team_id);
			$flg_bit = TeamStatus::STATUS_FLG_BIT_QUIZ[$quiz_no];
			return (bool)(($current_status & $flg_bit) > 0);
		}
		
		
		/**
		 * チームがアイテム2使用済みかチェックする
		 * @param int team_id 
		 */
		public static function isUsedItem2($team_id){
			$current_status = TeamStatus::getStatus($team_id);
			return (bool)(($current_status & TeamStatus::STATUS_FLG_BIT_ITEM_2) > 0);
		}
		
		/**
		 * チームがアイテム1回答送信済みかチェックする
		 * @param int team_id 
		 */
		public static function isSentAnswer($team_id){
			$current_status = TeamStatus::getStatus($team_id);
			return (bool)(($current_status & TeamStatus::STATUS_FLG_BIT_ANSWER) > 0);
		}
		
		/**
		 * 指定されたステータスフラグを表す数値から指定されたフラグが立っているかチェック
		 * @param int status チェック対象のステータスフラグを表す数値
		 * @param int status_flg_bit チェックする項目のフラグ
		 */
		public static function checkStatus($status, $status_flg_bit){
			return ($status & $status_flg_bit) > 0;
		}
		
		/**
		 * チームのステータスを初期状態にリセットする
		 * @param int team_id 
		 */
		public static function resetStatus($team_id){
			TeamStatus::doUpdateStatus($team_id, 0);
		}
		
		private static function doUpdateStatus($team_id, $status){
			$db = Database::connect();
			$db->query("update TEAM set STATUS = $status where TEAM_ID = $team_id");
		}
	}
?>