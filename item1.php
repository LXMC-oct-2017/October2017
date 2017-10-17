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
	<script type="text/javascript" src="js/Deal.js"></script>
</head>
<body>
  <div id="header">
    <img src="img/luxa_header.png" width="100%"/>
  </div>
  <div id="contents-inner">
		<ul>
			<li class="switch">クイズ１</li>
			<li class="switch">クイズ２</li>
			<li class="switch">クイズ３</li>
			<li class="switch">クイズ４</li>
		</ul>
  </div>
	<div class="home"><a href="index.php">< HOMEへ</a></div>
  <div id="footer">
    <img src="img/luxa_footer.png" width="100%"/>
  </div>

<script>
var dealList = [];
var selectDealList = [];

$('.switch').on('click', function() {
  var index = $(this).index();
	var itemNo = index + 1;
	ans = prompt("クイズ" + itemNo + "の答えを入力してください");
	// ajaxでitemNo毎の答えをselectして代入
	var selectAns = "test"; // test data
	if (ans === selectAns){
		alert("正解です！");

		$(".switch").remove();

		if ($('.deals').length) {
			$(".deals").remove();
			$(".submit").remove();
	  } else {
		  let onSucceeded = function(json) {
				dealList = new Array();
				json.forEach(function(val, key) {
					var deal = new Deal(1, json[key].dealId, json[key].dealTitle, json[key].dealPrice, json[key].category);
					dealList.push(deal);
				});
			};

			var $message = $('<div class="message"><p>アイテム1を使用するディールを選択してください</br>選択したディールの金額を公開されます</p></div>');
			$('#contents-inner').append($message);

			var $file1 = $('<div class="file" id="file0" value="0">価格帯（低）</div>');
			$('.message').append($file1);

			var $file2 = $('<div class="file" id="file1" value="1">価格帯（中）</div>');
			$('.message').append($file2);

			var $file3 = $('<div class="file" id="file2" value="2">価格帯（高）</div>');
			$('.message').append($file3);

			let api = new LxmcApi();
			api.errorHandler = function(data){console.log(data);};
		  api.callApi('api/get-deal-all.php', onSucceeded);
		}
	} else {
		alert("不正解です！");
		// 遷移先の修正
		window.location.href = 'index.php';
	}
});

$('#contents-inner').on('click', '.file', function() {
	if ($('.deals').length) {
		$('.deals').remove();
		$('.submit').remove();
		$('.page-bottom').remove();
	} else {
		var $value = $(this).attr('value');
		selectDealList = new Array();
		// $valueをもとにディール取得
		for(var i = 0; i < dealList.length; i++) {
			if(dealList[i].dealCategory == $value) {
				selectDealList.push(dealList[i]);
			}
		}

		// deals生成
		var list = document.createElement('div');
		list.className = 'deals';

		// dealを生成
		for(var i = 0; i < selectDealList.length; i++) {
			var $radio = $('<input></input>', {
				name: "radio-group",
				type: "radio",
				value: selectDealList[i].dealId,
			});

			var $dealTitle = $('<p></p>', {
				"class": "deal-title",
				html: selectDealList[i].dealTitle
			});

			var $deal = $('<div>').addClass('deal').append($radio).append($dealTitle).wrapInner('<label></label>');
			list.appendChild($deal[0]);
		}
		$('#' + 'file' + $value).after(list);

		// ディール金額公開ボタン
		$('.deals').after('<div class="submit" href="javascript:void(0);">ディール金額公開</div>');

		// 画面下部遷移ボタン
		var $moveBtn = $('<div></div>', {
			id: "page-bottom",
			'class': "page-bottom"
		});

		var $moveSub = $('<a></a>', {
			id: "move-submit",
			'class': "move-submit",
			href: "javascript:void(0);",
			html: '▼'
		});

		var $moveBottomBtn = $($moveBtn).append($moveSub).wrapInner('<p></p>');
		$('#contents-inner').before($moveBottomBtn);
	}
}).css('cursor','pointer');

$('#contents-inner').on('click', '.submit', function() {
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
			 $('.deals').remove();
			 $('p').remove();
			 $('.switch').remove();
			 $('.submit').remove();
			 $('.file').remove();

			 $('.message').append('<p><b>' + json['dealTitle'] + '</b>の金額は</br><center><b>' + json['dealPrice'] + '</b></center></br><center>です</center></p>');
		 }

		 api.callApi('api/use-item1.php', onSucceeded);
	 }
}).css('cursor','pointer');

$(document).on('click', '.move-submit', function(){
	var target = $('.submit');
	$(window).scrollTop(target.offset().top);
}).css('cursor','pointer');
</script>
</body>
</html>
