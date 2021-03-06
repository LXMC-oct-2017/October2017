<?php
	require_once dirname(__FILE__).'/api/auth-util.php';
	AuthUtil::redirectIfNotLoggedIn();
?>
<html>
<head>
  <meta charset="utf-8">
  <title>lxmc home</title>
  <meta name="viewport" content="width=380px">
  <link rel="stylesheet" type="text/css" href="css/common.css">
  <link rel="stylesheet" type="text/css" href="css/index.css">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
  <div id="item-use-history">
    <table id="item-use-history-table">
    </table>
  </div>
  <div id="header">
    <img src="img/luxa_header.png" width="100%"/>
  </div>
  <div id="contents-inner">
    <?php
		require_once 'api/database/database.php';
		$team_id = $_SESSION['LXMC_TEAM'];
		$db = Database::connect();
		$sql = 'SELECT item_id FROM item_use_history WHERE team_id = :team_id;'; //Query
		$history = $db -> prepare($sql);
		$history -> bindParam(':team_id', $team_id);
		$history -> execute();

		require_once 'api/team-status.php';
		$is_used_item1 = TeamStatus::isUsedItem1($team_id);
		$is_used_item2 = TeamStatus::isUsedItem2($team_id);
		createItemLink('アイテム１', 'item1.php', 'アイテム1は使用済みです', $is_used_item1);
		createItemLink('アイテム２', 'item2.php', 'アイテム2は使用済みです', $is_used_item2);

		function createItemLink($innerHtml, $action, $message_when_used, $is_used){
			$when_unavailable = '<div class="message"><p><center>'.$message_when_used.'</center></p></div>';
			$when_available = '<a href="'.$action.'" class="link" onClick="isAvailableUseItem()">'.$innerHtml.'</a>';
			echo $is_used ? $when_unavailable : $when_available;
		}
    ?>
    <a href="answer.php" class="link answer">回答する</a>
  </div>
  <div id="footer">
    <img src="img/luxa_footer.png" width="100%"/>
  </div>
</body>
</html>
