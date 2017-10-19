<?php
	require_once dirname(__FILE__).'/api/auth-util.php';
	AuthUtil::redirectIfNotLoggedIn();
?>
<html>
<head>
	<meta charset="utf-8">
  <title>lxmc item2</title>
	<meta name="viewport" content="width=380px">
  <link rel="stylesheet" type="text/css" href="css/common.css">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="js/LxmcApi.js"></script>
	<script type="text/javascript" src="js/Deal.js"></script>
</head>
<body>
  <div id="header">
    <img src="img/luxa_header.png" width="100%"/>
  </div>
	<div id="contents-inner">
	  <div class="message">
	    <p>ディールを選択してください（複数選択可）</br>
	    選択したディールの合計金額と目標金額との差分を公開します
	  　</p>
	  </div>
	</div>
	<div class="home"><a href="index.php">< HOMEへ</a></div>
  <div id="footer">
    <img src="img/luxa_footer.png" width="100%"/>
  </div>
<script type="text/javascript" src="js/common.js"></script> 
<script type="text/javascript" src="js/item2.js"></script>
</body>
</html>
