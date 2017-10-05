<?php
	require_once dirname(__FILE__).'/api/auth-util.php';
	AuthUtil::redirectIfNotLoggedIn();
?>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=380px">
  <title>lxmc answer</title>
  <link rel="stylesheet" type="text/css" href="css/common.css">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="js/LxmcApi.js"></script>
</head>
<body>
  <div id="header">
    <img src="img/luxa_header.png" width="100%"/>
  </div>
  <div id="contents-inner">
    <div class="message">
      <p>ディールを選択してください（複数可）</br>
      選択されたディールの合計金額を公開します
    　</p>
    </div>
    <button class="switch">ディール一覧</button>
  </div>
  <div id="footer">
    <img src="img/luxa_footer.png" width="100%"/>
  </div>

<script>
$('.switch').click(function() {
  if ($('.deals').length) {
    $(".deals").remove();
    $("form").remove();
  } else {
	  let onSucceeded = function(json) {
        var list = document.createElement('div');
        list.className = 'deals';

        json.forEach(function(val, key) {
          var $checkbox = $('<input></input>', {
            name: "checkbox-group[]",
            type: "checkbox",
            value: json[key].dealId,
          });

          var $dealTitle = $('<p></p>', {
            "class": "deal-title",
            html: json[key].dealTitle
          });

          var $deal = $('<div>').addClass('deal').append($checkbox).wrapInner($dealTitle);

          list.appendChild($deal[0]);
        });

        $('.switch').after('<form action="result.php" method="POST" name="checkbox-group">');
        $('form').wrapInner(list);
        $('.deals').after('<input class="submit" type="submit" value="合計金額公開"/>');
      };

	  let api = new LxmcApi();
	  api.errorHandler = function(data){console.log(data);};
	  api.callApi('api/get-deal-all.php', onSucceeded );
  }
});

</script>
</body>
</html>
