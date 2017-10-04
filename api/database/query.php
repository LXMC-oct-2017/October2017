<?php
	/**
	 * 
	 */
	class QueryUtil{
		
		/**
		 * SQL の　IN句を生成する
		 * @param array $array in()の中に記述する要素の配列
		 * @return string カンマ区切りの配列の要素
		 */
		public static function whereIn($array){
			$in_str = '';
			foreach( $array as $elem ){
				if( strlen($in_str) > 0 ){
					$in_str .= ', ';
				}
				$in_str .= $elem;
			}
			return 'in('.$in_str.')';
		}
		
		/**
		 * SQL文中の文字列型に変換
		 * 先頭と末尾に'を挿入する
		 * @param anu $elem 変換する要素
		 * @return string 先頭と末尾に'をつけた要素
		 */
		public static function toSqlString($elem){
			return "'{$elem}'";
		}
	}
?>