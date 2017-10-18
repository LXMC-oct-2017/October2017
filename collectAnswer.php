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
	$answers = $db->query('select * from ANSWER');

	$i = 0;
	$array = [];
	foreach( $answers as $value ){
		$ans['ANSWER_ID'] = $value['ANSWER_ID'];
		$ans['TEAM_ID'] = $value['TEAM_ID'];
		$ans['ANSWER_PRICE'] = $value['ANSWER_PRICE'];
		$ans['ANSWER_DATETIME'] = $value['ANSWER_DATETIME'];

		$sort[$i] = abs($target_money - $ans['ANSWER_PRICE']);
		$array[$i] = $ans;
		++$i;
	}

	array_multisort($sort, SORT_ASC, $array);

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

	foreach( (array)$array as $ans ){
		echo '<div class="result">TEAM_ID: '.$ans['TEAM_ID'].' PRICE : '.$ans['ANSWER_PRICE'].'</div><br>';
    echo '<div class="result">TEAM_ID: '.$ans['TEAM_ID'].' PRICE : '.$ans['ANSWER_PRICE'].'</div><br>';
    echo '<div class="result">TEAM_ID: '.$ans['TEAM_ID'].' PRICE : '.$ans['ANSWER_PRICE'].'</div><br>';
    echo '<div class="result">TEAM_ID: '.$ans['TEAM_ID'].' PRICE : '.$ans['ANSWER_PRICE'].'</div><br>';
    echo '<div class="result">TEAM_ID: '.$ans['TEAM_ID'].' PRICE : '.$ans['ANSWER_PRICE'].'</div><br>';
    echo '<div class="result">TEAM_ID: '.$ans['TEAM_ID'].' PRICE : '.$ans['ANSWER_PRICE'].'</div><br>';
    echo '<div class="result">TEAM_ID: '.$ans['TEAM_ID'].' PRICE : '.$ans['ANSWER_PRICE'].'</div><br>';
    echo '<div class="result">TEAM_ID: '.$ans['TEAM_ID'].' PRICE : '.$ans['ANSWER_PRICE'].'</div><br>';
    echo '<div class="result">TEAM_ID: '.$ans['TEAM_ID'].' PRICE : '.$ans['ANSWER_PRICE'].'</div><br>';
    echo '<div class="result">TEAM_ID: '.$ans['TEAM_ID'].' PRICE : '.$ans['ANSWER_PRICE'].'</div><br>';
    echo '<div class="result">TEAM_ID: '.$ans['TEAM_ID'].' PRICE : '.$ans['ANSWER_PRICE'].'</div><br>';
    echo '<div class="result">TEAM_ID: '.$ans['TEAM_ID'].' PRICE : '.$ans['ANSWER_PRICE'].'</div><br>';
    echo '<div class="result">TEAM_ID: '.$ans['TEAM_ID'].' PRICE : '.$ans['ANSWER_PRICE'].'</div><br>';
    echo '<div class="result">TEAM_ID: '.$ans['TEAM_ID'].' PRICE : '.$ans['ANSWER_PRICE'].'</div><br>';
    echo '<div class="result">TEAM_ID: '.$ans['TEAM_ID'].' PRICE : '.$ans['ANSWER_PRICE'].'</div><br>';
    echo '<div class="result">TEAM_ID: '.$ans['TEAM_ID'].' PRICE : '.$ans['ANSWER_PRICE'].'</div><br>';
	}

	$db = null;
?>
</div>
<script type="text/javascript" src="js/collectAnswer.js"></script>
</body>
</html>
