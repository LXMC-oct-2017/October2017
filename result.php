<?php
	require_once dirname(__FILE__).'/api/auth-util.php';
	AuthUtil::redirectIfNotLoggedIn();
?>
<html>
<head>
  <title>lxmc result</title>
	<meta name="viewport" content="width=380px">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="js/LxmcApi.js"></script>
  <link rel="stylesheet" type="text/css" href="css/common.css">
</head>
<body>
  <div id="header">
    <img src="img/luxa_header.png" width="100%"/>
  </div>
	<div id="contents-inner">
<?php
	require_once dirname(__FILE__).'/api/config.php';
	$config = Config::getInstance()->getConfig('general');
	require_once dirname(__FILE__).'/api/database/database.php';
	require_once dirname(__FILE__).'/api/database/query.php';
	require_once dirname(__FILE__).'/api/team-status.php';

	$deal_id_list = [];
	foreach( (array)$_POST['checkbox-group'] as $deal_id ){
		array_push( $deal_id_list, intval($deal_id) );
	}
	$in_str = QueryUtil::whereIn($deal_id_list);

	$db = Database::connect();
	$result = $db->query("select * from DEAL where DEAL_ID $in_str");
	$sum = 0;
	$deal_title_list = [];
	foreach( $result as $row ){
		$sum += $row['DEAL_PRICE'];
	}
	array_push( $deal_title_list, $row['DEAL_TITLE']);
	$db = null;
	$result = null;

	$team_id = $_SESSION['LXMC_TEAM'];
	require_once dirname(__FILE__).'/api/send-answer.php';

	registerAnswer($team_id, $sum, $deal_id_list);
	TeamStatus::sendAnswer($team_id);
?>
		<div class="spacer"></div>
		<div id="message">
	    <p><center>結果発表まで少々お待ちください</center>
	    </p>
	  </div>
		<div class="spacer"></div>
	</div>
  <div id="footer">
    <img src="img/luxa_footer.png" width="100%"/>
  </div>
</body>
</html>
