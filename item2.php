<?php
	session_start();
	if( !isset($_SESSION['LXMC_TEAM']) ){
		header('Location: /lxmc/login/login.php');
		exit;
	}
?>
<html>
<head>
  <title>lxmc item2</title>
  <link rel="stylesheet" type="text/css" href="css/common.css">
  <link rel="stylesheet" type="text/css" href="css/home.css">
</head>
<body>
  <div id="header">
    <img src="img/luxa_header.png" width="100%"/>
  </div>
  <div class="message">
    <p>ディールを選択してください（複数可）</br>
    選択したディールの合計金額と目標金額との差分を公開します
  　</p>
  </div>
  <!-- ディール一覧 -->
  <div class="link">
    <a href="item2Result.php">差分をみる</a>
  </div>
  <div id="footer">
    <img src="img/luxa_footer.png" width="100%"/>
  </div>
</body>
</html>
