<?php
	session_start();
	if( !isset($_SESSION['LXMC_TEAM']) ){
		header('Location: /lxmc/login/login.php');
		exit;
	}
?>
<html>
<head>
  <title>lxmc item2Result</title>
  <link rel="stylesheet" type="text/css" href="css/common.css">
  <link rel="stylesheet" type="text/css" href="css/home.css">
</head>
<body>
  <div id="header">
    <img src="img/luxa_header.png" width="100%"/>
  </div>
  <div class="message">
    <p>目標金額と選択されたディールの合計金額の差は
      <span>
        〜円です
      </span>
  　</p>
  </div>
  <div class="link">
    <a href="index.php">HOMEへ</a>
  </div>
  <div id="footer">
    <img src="img/luxa_footer.png" width="100%"/>
  </div>
</body>
</html>
