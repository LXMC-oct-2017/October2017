<?php
	require_once dirname(__FILE__).'/api/auth-util.php';
	AuthUtil::redirectIfNotLoggedIn();
?>
<html>
<head>
  <meta charset="utf-8">
  <title>lxmc item1</title>
  <meta name="viewport" content="width=380px">
  <link rel="stylesheet" type="text/css" href="css/common.css">
  <link rel="stylesheet" type="text/css" href="css/item1.css">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="js/LxmcApi.js"></script>
</head>
<body>
  <div id="header">
    <img src="img/luxa_header.png" width="100%"/>
  </div>
  <div id="contents-inner">
    <div class="message">
      <p>アイテム1を使用するディールを選択してください</br>
      選択したディールの金額を公開されます
    　</p>
    </div>
    <button class="switch">ディール一覧</button>
    <button class="submit">ディール金額公開</button>
  </div>
  <div id="footer">
    <img src="img/luxa_footer.png" width="100%"/>
  </div>

<script>
$('body').ready(function(){
		ans = prompt("クイズの答えを入力してください");
		var dispatch = '';
		if (ans === '愛'){
		} else {
			window.location.href = 'index.php';
		}
});

$('.switch').click(function() {
  if ($('.deals').length) {
    $(".deals").remove();
  } else {
	  let onSucceeded = function(json) {
      var list = document.createElement('div');
      list.className = 'deals';

      json.forEach(function(val, key) {
        var $radio = $('<input></input>', {
          name: "radio-group",
          type: "radio",
          value: json[key].dealId,
        });

        var $dealTitle = $('<p></p>', {
          "class": "deal-title",
          html: json[key].dealTitle
        });

        var $deal = $('<div>').addClass('deal').append($radio).append($dealTitle);

        list.appendChild($deal[0]);
      });
      $('.submit').before(list);
		};

	  let api = new LxmcApi();
	  api.errorHandler = function(data){console.log(data);};
	  api.callApi('api/get-deal-all.php', onSucceeded);
  }
});

$('.submit').click(function() {
  dealId = $('[name="radio-group"]:checked').val();

	 if (dealId === undefined) {
		 alert("ディールを選択してください！");
	 } else {
		 let api = new LxmcApi();
		 api.data = {'dealId': dealId};
		 api.errorHandler = function(XMLHttpRequest, textStatus, errorThrown) {
			 console.log(XMLHttpRequest.status);
			 console.log(textStatus);
			 console.log(errorThrown.message);
		 }

		 let onSucceeded = function(json){
			 console.log(json['dealTitle']);
			 $('.deals').remove();
			 $('p').remove();
			 $('.switch').remove();
			 $('.submit').remove();

			 $('.message').append('<p>' + json['dealTitle'] + 'の金額は' + json['dealPrice'] + '円です</p>');
			 $('p').after('<div class="link"><a href="index.php">HOMEへ</a></div>');
		 }

		 api.callApi('api/use-item1.php', onSucceeded);
	 }
});
</script>

</body>
</html>
