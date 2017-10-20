var dealList = [];
var selectDealList = [];
var quizNo;
var displayQuizNo;


let = processQuizResponse = function(data){
	var $message = $('<div class="message"><p>アイテム1を使用するディールを1個選択してください</br>選択したディールの金額を公開されます</p></div>');
	$('#contents-inner').append($message);

	if (data.flag){
		alert("正解です！");
		$('ul').remove();


		let onSucceeded = function(json) {
			dealList = new Array();
			json.forEach(function(val, key) {
				var deal = new Deal(json[key].dealId, json[key].dealTitle, json[key].dealPrice, json[key].category, json[key].no);
				dealList.push(deal);
			});
			//	create file elements and its root
			var $file0 = $('<div class="file" id="file0"></div>').append($('<div class="file-title" id="file-title0" value="0">価格帯（低）</div>'));
			var $file1 = $('<div class="file" id="file1"></div>').append($('<div class="file-title" id="file-title1" value="1">価格帯（中）</div>'));
			var $file2 = $('<div class="file" id="file2"></div>').append($('<div class="file-title" id="file-title2" value="2">価格帯（高）</div>'));

			// create deals root element
			var $deal = $('<div>').addClass('files').append($file0).append($file1).append($file2);
			$('.message').after($deal);

			// ディール金額公開ボタン(制御)
			var $form = $('<form></form>');
			$('.files').wrap($form);
			$('.files').after('<div><center><input class="submit" type="button" value="金額公開"/></center></div>');

			createDealInputForm(dealList, function(){
				return {name: "radio-group", type: "radio"}
			});
		};
		let api = new LxmcApi();
		api.errorHandler = function(data){console.log(data);};
		api.callApi('./api/get-deal-all.php', onSucceeded);
	} else {
		alert("不正解です！");
		window.location.href = 'index.php';
	}
}

/**
 * open and close files
 */
$('#contents-inner').on('click', '.file-title', function(){
	const FADE_DURATION_MILLI_SEC = 500;
	let idx = $(this).attr("value");
	for(let i=0; i<3; ++i ){
		let file = $('#file'+i);
		if( idx == i ){
			let hiddenChild = file.children('.deals:hidden');
			console.log(hiddenChild.length);
			if( hiddenChild.length > 0 ){
				file.children('.deals').show(FADE_DURATION_MILLI_SEC);
			}else{
				file.children('.deals').hide(FADE_DURATION_MILLI_SEC);
			}
		}else{
			file.children('.deals').hide(FADE_DURATION_MILLI_SEC);
		}
	}

// TODO これよくわからんから後回し
//	var $moveBtn = $('<div></div>', {
//		id: "page-bottom",
//		'class': "page-bottom"
//	});
//
//	var $moveSub = $('<a></a>', {
//		id: "move-submit",
//		'class': "move-submit",
//		href: "javascript:void(0);",
//		html: '▼'
//	});
//
//	var $moveBottomBtn = $($moveBtn).append($moveSub).wrapInner('<p></p>');
//	$('#contents-inner').before($moveBottomBtn);

}).css('cursor','pointer');


$('.switch').on('click', function() {
	quizNo = $(this).index();
	displayQuizNo = $(this).index() + 1;

	let ans = prompt("クイズ" + displayQuizNo + "の答えを入力してください\n※答えは半角で入力してください");
	var api = new LxmcApi();
	api.data = {"quizNo":quizNo, "ans":ans};
	api.callApi('./api/quiz.php', processQuizResponse);
});


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
