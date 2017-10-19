<html>
<head>
  <title>lxmc collect answer</title>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="js/LxmcApi.js"></script>
	<link rel="stylesheet" type="text/css" href="css/collectAnswer.css">
</head>
<body>
	<div id="contents-inner">
<?php
	require_once dirname(__FILE__).'/api/config.php';
	require_once dirname(__FILE__).'/api/database/database.php';

	$config = Config::getinstance()->getConfig('general');
	$target_money = $config['target_money'];

	$db = Database::connect();
	$answers = $db->query("SELECT rank, team_name, answer.answer_price, 70000 - answer.answer_price as 'dif' FROM (
        SELECT answer_price, @rank AS rank, cnt, @rank := @rank + cnt FROM
            (SELECT @rank := 1) AS Dummy,
            (SELECT answer_price, count(*) AS cnt FROM answer GROUP BY answer_price ORDER BY answer_price DESC) AS GroupBy
        ) AS Ranking
        JOIN answer ON answer.answer_price = Ranking.answer_price
        JOIN team ON answer.team_id = team.team_id
        ORDER BY rank ASC;");

	$i = 0;
	$array = [];
	foreach( $answers as $value ){
    $ans['RANK'] = $value['rank'];
		$ans['TEAM_NAME'] = $value['team_name'];
		$ans['ANSWER_PRICE'] = $value['answer_price'];
		$ans['DIF'] = $value['dif'];

		//$sort[$i] = abs($target_money - $ans['ANSWER_PRICE']);
		$array[$i] = $ans;
		++$i;
	}



	//array_multisort($sort, SORT_ASC, $array);



/*
	$rank = 0;
	for($i = 0; $i < count($array); $i++) {
		int tied = 0;
		if ($array[i] != $array[i+1]) {

		} else {
			tied++;
		}
	}
	*/
  echo '<div id="top">他チームは別途発表</div><br>';
  echo '<div id="teamResult">';
	foreach( (array)$array as $ans ){
		echo '<div class="result">'.$ans['RANK'].'位 TEAM_NAME:'.$ans['TEAM_NAME'].' PRICE'.$ans['ANSWER_PRICE'].'DIF: '.$ans['DIF'].'</div>';
	}
  echo '</div>';

	$db = null;

  // ランキング処理
  function rankTeam($array) {
    $rank = 0;
    foreach( $array as $value ) {
      //$value['answer']
    }
  }
?>
</div>
<script type="text/javascript" src="js/collectAnswer.js"></script>
</body>
</html>
