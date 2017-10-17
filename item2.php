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
	  <div class="switch">ディール一覧</div>
	</div>
	<div class="home"><a href="index.php">< HOMEへ</a></div>
  <div id="footer">
    <img src="img/luxa_footer.png" width="100%"/>
  </div>
<script>
var dealList = [];
var selectDealList = [];

$('body').ready(function(){
		ans = prompt("クイズの答えを入力してください");
		var dispatch = '';
		if (ans === 'ギリシャ'){
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

				var $file1 = $('<div class="file" id="file0" value="0">価格帯（低）</div>');
				var $file2 = $('<div class="file" id="file1" value="1">価格帯（中）</div>');
				var $file3 = $('<div class="file" id="file2" value="2">価格帯（高）</div>');

				var $deal = $('<div>').addClass('files').append($file1).append($file2).append($file3);
				$('.message').after($deal);
				
				let api = new LxmcApi();
				api.errorHandler = function(data){console.log(data);};
			  api.callApi('api/get-deal-all.php', onSucceeded);
			}
		} else {
			alert("不正解です！");
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
				name: "checkbox-group",
				type: "checkbox",
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

$(document).on('click', '.submit', function() {
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
		$('.page-bottom').remove();
		$('.file').remove();

		$('.message').append('<p>目標金額と選択されたディールの合計金額の差は</br>' + json['useResult'] + '</br>です</p>');
	}

	api.callApi('api/use-item2.php', onSucceeded);
}).css('cursor','pointer');

$(document).on('click', '.move-submit', function(){
	var target = $('.submit');
	$(window).scrollTop(target.offset().top);
}).css('cursor','pointer');
</script>

</body>
</html>
