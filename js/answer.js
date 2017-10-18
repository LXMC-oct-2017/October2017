var dealList = [];
var categoryDealList = [];
var selectDealIdList = [];

$('body').ready(function(){
	var $file1 = $('<div class="file" id="file0" value="0">価格帯（低）</div>');
	var $file2 = $('<div class="file" id="file1" value="1">価格帯（中）</div>');
	var $file3 = $('<div class="file" id="file2" value="2">価格帯（高）</div>');

	var $deal = $('<div>').addClass('files').append($file1).append($file2).append($file3);
	$('.message').after($deal);

	let onSucceeded = function(json) {
		dealList = new Array();
		json.forEach(function(val, key) {
			var deal = new Deal(json[key].dealId, json[key].dealTitle, json[key].dealPrice, json[key].category, json[key].no);
			dealList.push(deal);
		});
	};

	let api = new LxmcApi();
	api.errorHandler = function(data){console.log(data);};
	api.callApi('api/get-deal-all.php', onSucceeded);
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
				value: categoryDealList[i].dealId,
			});

			var $dealTitle = $('<p></p>', {
				"class": "deal-title",
				html: categoryDealList[i].no + '. ' + categoryDealList[i].dealTitle
			});

			var $deal = $('<div>').addClass('deal').append($radio).append($dealTitle).wrapInner('<label></label>');
			list.appendChild($deal[0]);
		}
		$('#' + 'file' + $value).after(list);

		// ディール金額公開ボタン(制御)
		var $form = $('<form action="result.php" method="POST" name="checkbox-group"/>');
		$('.files').wrap($form);
		$('.files').after('<input class="submit" type="submit" value="合計金額公開"/>');

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

$(document).on('click', '.submit', function(){
  //$('form').submit(function() {
    if (selectDealIdList.length <= 5) {
      alert("ディールは各価格帯から最低2個選択してください！");
      return false;
    }
  //});
});

$(document).on('click', '.move-submit', function(){
	var target = $('.submit');
	$(window).scrollTop(target.offset().top);
}).css('cursor','pointer');

$(document).on('click', '.submit', function() {

});
