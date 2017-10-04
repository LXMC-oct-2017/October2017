<?php
	session_start();
	if( !isset($_SESSION['LXMC_TEAM']) ){
		header('Location: /lxmc/login/login.php');
		exit;
	}
?>
<html>
<head>
  <meta charset="utf-8">
  <title>lxmc item1Result</title>
  <meta name="viewport" content="width=380px">
  <link rel="stylesheet" type="text/css" href="css/common.css">
  <link rel="stylesheet" type="text/css" href="css/home.css">
</head>
<body>
  <div id="header">
    <img src="img/luxa_header.png" width="100%"/>
  </div>
  <div class="message">
    <p>〜の金額は
      <span>
        〜円です
      </span>
  　</p>
  </div>
  <!-- ディール一覧 -->
  <div class="link">
    <a href="index.php">HOMEへ</a>
  </div>
  <div id="footer">
    <img src="img/luxa_footer.png" width="100%"/>
  </div>
</body>
</html>
