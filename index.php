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

		$item_use_ids = $history -> fetchAll(PDO::FETCH_COLUMN, 'item_id');
		if (empty($item_use_ids)) {
			echo '<a href="item1.php" class="link">アイテム１</a>';
			echo '<a href="item2.php" class="link">アイテム２</a>';
		} else {
			$item_no = 0; // アイテム1
			if (count($item_use_ids) == 1 && current($item_use_ids) == $item_no) {
        echo '<div class="message"><p>アイテム1は使用済みです</p></div>';
        echo '<a href="item2.php" class="link">アイテム２</a>';
			} else if (count($item_use_ids) == 1 && current($item_use_ids) != $item_no) {
        echo '<a href="item1.php" class="link">アイテム１</a>';
				echo '<div class="message"><p>アイテム2は使用済みです</p></div>';
			}else{
				echo '<div class="message"><p>アイテム1は使用済みです</p></div>';
				echo '<div class="message"><p>アイテム2は使用済みです</p></div>';
			}
		}
    ?>
    <a href="answer.php" class="link answer">回答する</a>
  </div>
  <div id="footer">
    <img src="img/luxa_footer.png" width="100%"/>
  </div>

  <script type="text/javascript">
    $('body').ready(function(){
        getItemUseHistory();
    });

    let getItemUseHistory = function(teamId){
        $.ajax({
            type: "GET",
            url: "./api/get-item-use-history.php",
            dataType: "json",
            success: showJson,
            error: function( data ){console.log(data.responseText);},
        });
    }

    let createTable = function(){
        let table = $('<table></table>').attr('id', 'item-use-history').appendTo('#item-use-history');
        let tr = $('<tr></tr>').appendTo($('#item-use-history-table'));
        tr.append('<th>アイテム</th>');
        tr.append('<th>ディールID</th>');
        tr.append('<th>ITEM_USE_RESULT</th>');
    }

    let showJson = function(json){
        if(json.length == 0 ){
            return;
        }
        createTable();
        json.forEach( function(data){
            let teamId = data.teamId;
            let itemName = data.itemName;
            let dealIds = data.dealIdList;
            let itemUseResult = data.itemUseResult;
            let tr = $('<tr></tr>').appendTo($('#item-use-history-table'));
            tr.append('<td>'+itemName+'</td>');
            tr.append('<td>'+dealIds+'</td>');
            tr.append('<td>'+itemUseResult+'</td>');
        });
    }

    let cleanTable = function(){
        $('#item-use-history-table').empty();
        let tr = $("<tr></tr>").appendTo($('#item-use-history-table'));
        tr.append('<th>TEAM_ID</th>');
        tr.append('<th>ITEM_ID</th>');
        tr.append('<th>DEAL_ID_LIST</th>');
        tr.append('<th>ITEM_USE_RESULT</th>');
    }
  </script>
</body>
</html>
