var dealList = [];
var categoryDealList = [];
var selectDealIdList = [];
let quizNo = 4;
let displayQuizNo = quizNo + 1;

let = processQuizResponse = function(data){
	if (data.flag){
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

			var $file1 = $('<div class="file box" id="file0" value="0">価格帯（低）</div>');
			var $file2 = $('<div class="file box" id="file1" value="1">価格帯（中）</div>');
			var $file3 = $('<div class="file box" id="file2" value="2">価格帯（高）</div>');

			var $deal = $('<div>').addClass('files').append($file1).append($file2).append($file3);
			$('.message').after($deal);

			let api = new LxmcApi();
			api.errorHandler = function(data){console.log(data);};
		  api.callApi('./api/get-deal-all.php', onSucceeded);
		}
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

$('#contents-inner').on('click', '.file', function() {
	if ($('.deals').length) {
		$('.deals').remove();
		$('.submit').remove();
		$('.page-bottom').remove();
	} else {
		var $value = $(this).attr('value');
		categoryDealList = new Array();
		// $valueをもとにディール取得
		for(var i = 0; i < dealList.length; i++) {
			if(dealList[i].dealCategory == $value) {
				categoryDealList.push(dealList[i]);
			}
		}

		// deals生成
		var list = document.createElement('div');
		list.className = 'deals';

		// dealを生成
		for(var i = 0; i < categoryDealList.length; i++) {
			var $radio = $('<input></input>', {
				name: "checkbox-group",
				type: "checkbox",
				value: categoryDealList[i].dealId
			});

			var $dealTitle = $('<p></p>', {
				"class": "deal-title",
				html: categoryDealList[i].no + '. ' + categoryDealList[i].dealTitle
			});

			var $deal = $('<div>').addClass('deal').append($radio).append($dealTitle).wrapInner('<label></label>');
			list.appendChild($deal[0]);
		}
		$('#' + 'file' + $value).after(list);

    // チェックされているディールのチェックボックスにチェックを入れる
    for(var i = 0; i < selectDealIdList.length; i++) {
      for(var j = 0; j < categoryDealList.length; j++) {
        if (selectDealIdList[i] == categoryDealList[j].dealId) {
          var input = $("[value=" + selectDealIdList[i] +"]");
          $(input).prop("checked",true);
        }
      }
    }

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

$(document).on('change', 'input[type="checkbox"]', function() {
    if ($(this).is(':checked')) {
      selectDealIdList.push($(this).val());
    } else {
      for(i=0; i<selectDealIdList.length; i++){
        if(selectDealIdList[i] == $(this).val()){
          selectDealIdList.splice(i, 1);
        }
      }
    }
});

$('#contents-inner').on('click', '.submit', function() {
  	let api = new LxmcApi();
  	api.data = {'dealIdList[]': selectDealIdList};
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

  		$('.message').append('<p>目標金額と選択されたディールの合計金額の差は</br><center>' + json['useResult'] + '</center></br><center>です</center></p>');
  	}

  	api.callApi('api/use-item2.php', onSucceeded);
//  }
}).css('cursor','pointer');

$(document).on('click', '.move-submit', function(){
	var target = $('.submit');
	$(window).scrollTop(target.offset().top);
}).css('cursor','pointer');
