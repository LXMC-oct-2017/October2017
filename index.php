<?php
    session_start();
    if( !isset($_SESSION['LXMC_TEAM']) ){
        $login_url = './login/login.php';
        header("Location: $login_url");
        exit;
    }
?>
<html>
<head>
  <title>lxmc home</title>
  <link rel="stylesheet" type="text/css" href="css/common.css">
  <link rel="stylesheet" type="text/css" href="css/home.css">
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
＜？php
 require '../api/database/Database.php';
 $db = Database::create();
 $team_id = 2; //暫定id
 $sql = 'SELECT.history.item_id, history.item_use_result FROM item_use_history AS 'history' WHERE team_id = :team_id;'; //Query
 $history = $db -> prepare($sql);
 $history -> bindParam(':item_id, $team_id);
 $history -> execute();

 if (empty(fetchAll(PDO::FETCH_COLUMN, 'ITEM_ID'))) {
  echo '<div class="message">
          <p>アイテム1は使用済みです</p>
         </div>';
 } else {
  echo '<div class="link">
         <a href="item1.php">アイテム１</a>
        </div>';
 }
?>
  <div class="link">
    <a href="item2.php">アイテム２</a>
  </div>
  <div class="link">
    <a href="answer.php">回答する</a>
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
            url: "./api/item-use-history.php",
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
            let dealIds = data.dealIds;
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
