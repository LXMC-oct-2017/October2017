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
  <button class="switch">ディール一覧</button>
	<button class="submit">差分公開</button>
  <div id="footer">
    <img src="img/luxa_footer.png" width="100%"/>
  </div>
<script>
$('body').ready(function(){
		ans = prompt("クイズの答えを入力してください");
		var dispatch = '';
		if (ans === 'ギリシャ'){
		} else {
			window.location.href = 'index.php';
		}
});

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
            name: "checkbox-group",
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
				$('.submit').before(list);
      };

	  let api = new LxmcApi();
	  api.errorHandler = function(data){console.log(data);};
	  api.callApi('api/get-deal-all.php', onSucceeded );
  }
});

$('.submit').click(function() {
	var dealIdList = $('[name="checkbox-group"]:checked').map(function() {
	  return $(this).val();
	}).get();

		 let api = new LxmcApi();
		 api.data = {'dealIdList[]': dealIdList};
		 api.errorHandler = function(XMLHttpRequest, textStatus, errorThrown) {
			 console.log(XMLHttpRequest.status);
			 console.log(textStatus);
			 console.log(errorThrown.message);
		 }

		 let onSucceeded = function(json){
			 $('.deals').remove();
			 $('p').remove();
			 $('.switch').remove();
			 $('.submit').remove();

			 $('.message').append('<p>目標金額と選択されたディールの合計金額の差は' + json['useResult'] + 'です</p>');
			 $('p').after('<div class="link"><a href="index.php">HOMEへ</a></div>');
		 }

		 api.callApi('api/use-item2.php', onSucceeded);
});
</script>
</body>
</html>
