var dealList = [];
var categoryDealList = [];
var selectDealIdList = [];
var categoryList = [];
var counter;

var createCategoryDealList = function(){
	// dealを生成
	var $value = $(this).attr('value');
	selectDealList = new Array();

	let categoryDealList = [[], [], []];
	for( let deal of dealList ){
		categoryDealList[deal.dealCategory].push(deal);
	}

	// ディール金額公開ボタン(制御)
	var $form = $('<form action="result.php" method="POST" name="checkbox-group"/>');
	$('.files').wrap($form);
	$('.files').after('<input class="submit" type="submit" value="合計金額公開"/>');

	for( let i=0; i<3; ++i ){
		let list = document.createElement('div');
		list.className = 'deals';
		for( categoryDeal of categoryDealList[i] ){
				let $checkbox = $('<input></input>', {
					name: "checkbox-group[]",
					type: "checkbox",
					value: categoryDeal.dealId
				});
				var $dealTitle = $('<p></p>', {
					"class": "deal-title",
					html: categoryDeal.no + '. ' + categoryDeal.dealTitle
				});
				var divDeal = $('<div>').addClass('deal').append($checkbox).append($dealTitle).wrapInner('<label></label>');
				list.appendChild(divDeal[0])
		}
		$('#file' + i).append(list);
		$('#file' + i).children().hide();
	}
}

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
		createCategoryDealList();
	};

	let api = new LxmcApi();
	api.errorHandler = function(data){console.log(data);};
	api.callApi('api/get-deal-all.php', onSucceeded);
});

/**
 * ファイル開け閉め
 */
$('#contents-inner').on('click', '.file', function(){
	let idx = $(this).attr("value");
	for(let i=0; i<3; ++i ){

		if( idx == i ){
			$('#file'+idx).children().show();
		}
	}
}).css('cursor','pointer');

$(document).on('change', 'input[type="checkbox"]', function() {
    if ($(this).is(':checked')) {
      selectDealIdList.push($(this).val());

			for(var i = 0; i < dealList.length; i++) {
        if (dealList[i].dealId == $(this).val()) {
					console.log("add " + dealList[i].dealId);
					categoryList.push(dealList[i].dealCategory);
        }
      }
    } else {
      for(var i = 0; i < selectDealIdList.length; i++){
        if(selectDealIdList[i] == $(this).val()){
          selectDealIdList.splice(i, 1);
					break;
        }
      }

			var category;
			for(let i = 0; i < dealList.length; i++) {
        if (dealList[i].dealId == $(this).val()) {
					category = dealList[i].dealCategory;
        }
			}

			categoryList.some(function (v, k, list) {
				if (v == category) {
					list.splice(k, 1);
					return true;
				}
			});
    }
});

$(document).on('click', '.submit', function(){
	console.log(categoryList);
	console.log(selectDealIdList);
	var minSelectDeal = 2;
	var counts = {};

	for(var i = 0;i < categoryList.length; i++){
	  var key = categoryList[i];
	  counts[key] = (counts[key])? counts[key] + 1 : 1 ;
	}

	if (counts['0'] < minSelectDeal || counts['1'] < minSelectDeal || counts['2'] < minSelectDeal) {
		alert("ディールは各価格帯から最低2個選択してください！");
		return false;
	}
});

$(document).on('click', '.move-submit', function(){
	var target = $('.submit');
	$(window).scrollTop(target.offset().top);
}).css('cursor','pointer');

$(document).on('click', '.submit', function() {

});
