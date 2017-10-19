var dealList = [];
var selectDealList = [];
var quizNo;
var displayQuizNo;

$('.switch').on('click', function() {
	quizNo = $(this).index();
	displayQuizNo = $(this).index() + 1;
	ans = prompt("クイズ" + displayQuizNo + "の答えを入力してください\n※答えは半角で入力してください");
	let api = new LxmcApi();
	api.data = { "quizNo": quizNo, "ans": ans };
	api.errorHandler = function(data){console.log(data);};
	api.callApi('./api/quiz.php', processQuizResponse);
});

let processQuizResponse = function(data){
	if ( data.flag ){
		alert("正解です！");

		$(".switch").remove();

		if ($('.deals').length) {
			$(".deals").remove();
			$(".submit").remove();
	  } else {
		  let onSucceeded = function(json) {
				dealList = new Array();
				json.forEach(function(val, key) {
					var deal = new Deal(json[key].dealId, json[key].dealTitle, json[key].dealPrice, json[key].category, json[key].no);
					dealList.push(deal);
				});
			};

			var $message = $('<div class="message"><p>アイテム1を使用するディールを1個選択してください</br>選択したディールの金額を公開されます</p></div>');
			$('#contents-inner').append($message);

			var $file1 = $('<div class="file box" id="file0" value="0">価格帯（低）</div>');
			$('.message').append($file1);

			var $file2 = $('<div class="file box" id="file1" value="1">価格帯（中）</div>');
			$('.message').append($file2);

			var $file3 = $('<div class="file box" id="file2" value="2">価格帯（高）</div>');
			$('.message').append($file3);

			let api = new LxmcApi();
			api.errorHandler = function(data){console.log(data);};
			api.callApi('./api/get-deal-all.php', onSucceeded);
		}
	} else {
		alert("不正解です！");
		// 遷移先の修正
		window.location.href = 'index.php';
	}
}

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
				html: selectDealList[i].no + '. ' + selectDealList[i].dealTitle
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
		 api.data = {'dealId': dealId, 'quizNo': quizNo};
		 api.errorHandler = function(data) {
			 alert("クイズ" + displayQuizNo + "は回答済みです");
		 }

		 let onSucceeded = function(json){
			 $('.deals').remove();
			 $('p').remove();
			 $('.switch').remove();
			 $('.submit').remove();
			 $('.file').remove();

			 $('.message').append('<p><b>' + json['no'] + '. ' + json['dealTitle'] + '</b>の金額は</br><center><b>' + json['dealPrice'] + '</b></center></br><center>です</center></p>');
		 }
		 api.callApi('./api/use-item1.php', onSucceeded);
	 }
}).css('cursor','pointer');

$(document).on('click', '.move-submit', function(){
	var target = $('.submit');
	$(window).scrollTop(target.offset().top);
}).css('cursor','pointer');
