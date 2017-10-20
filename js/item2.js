var dealList = [];
var categoryDealList = [];
var selectDealIdList = [];
let quizNo = 4;
let displayQuizNo = quizNo + 1;

let = processQuizResponse = function(data){
	if (data.flag){
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
		$('.files').after('<div><center><input class="submit" type="button" value="合計金額公開"/></center></div>');

		createDealInputForm(dealList, function(){
			return {name: "checkbox-group", type: "checkbox"}
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

$('body').ready(function(){
	let ans = prompt("クイズ" + displayQuizNo + "の答えを入力してください\n※答えは半角で入力してください");
	var api = new LxmcApi();
	api.data = {"quizNo":quizNo, "ans":ans};
	api.callApi('./api/quiz.php', processQuizResponse);
});

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
			if( hiddenChild.length > 0 ){
				file.children('.deals').show(FADE_DURATION_MILLI_SEC);
			}else{
				file.children('.deals').hide(FADE_DURATION_MILLI_SEC);
			}
		}else{
			file.children('.deals').hide(FADE_DURATION_MILLI_SEC);
		}
	}
}).css('cursor','pointer');

$(document).on('change', 'input[type="checkbox"]', function() {
    if ($(this).prop('checked')) {
      selectDealIdList.push($(this).val());
    } else {
      for(i=0; i<selectDealIdList.length; i++){
        if(selectDealIdList[i] == $(this).val()){
          selectDealIdList.splice(i, 1);
        }
      }
    }
});

$(document).on('click', '.submit', function() {
  	let api = new LxmcApi();
	console.log(selectDealIdList);
  	api.data = {'dealIdList[]': selectDealIdList};

  	let onSucceeded = function(json){
  		$('.deals').remove();
  		$('p').remove();
  		$('.switch').remove();
  		$('.submit').remove();
  		$('.page-bottom').remove();
  		$('.file').remove();

  		$('.message').append('<p>目標金額と選択されたディールの合計金額の差は</br><center>' + json['useResult'] + '</center></br><center>です</center></p>');
  	}

  	api.callApi('api/use-item2.php', onSucceeded);
}).css('cursor','pointer');

$(document).on('click', '.move-submit', function(){
	var target = $('.submit');
	$(window).scrollTop(target.offset().top);
}).css('cursor','pointer');
