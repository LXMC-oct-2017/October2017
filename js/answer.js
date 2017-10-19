var dealList = [];
var categoryDealList = [];
var selectDealIdList = [];
var categoryList = [];
var counter;

/**
 * on body get ready
 */
$('body').ready(function(){
	let onSucceeded = function(json) {
		dealList = new Array();
		json.forEach(function(val, key) {
			var deal = new Deal(json[key].dealId, json[key].dealTitle, json[key].dealPrice, json[key].category, json[key].no);
			dealList.push(deal);
		});
		createDealInputForm( dealList, function(){
			return { name: "checkbox-group[]", type: "checkbox"}
		});
	};

	let api = new LxmcApi();
	api.errorHandler = function(data){console.log(data);};
	api.callApi('api/get-deal-all.php', onSucceeded);
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
}).css('cursor','pointer');

/**
 * 
 */
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

/**
 * validate input check box
 */
$(document).on('click', '.submit', function(){
	console.log('validate');
	let dealCount = [0, 0, 0];
	
	let selectedDeals = [];
	for(let deal of dealList){
		if( selectDealIdList.includes(deal.dealId) ){
			selectedDeals.push(deal);
		}
	}

	for( let deal of selectedDeals ){
		console.log(deal.dealCategory);
		dealCount[deal.dealCategory] += 1;
	}
	console.log(dealCount);

	let validationError = false;
	for( let count of dealCount ){
		if( count < 2 ){
			validationError = true;
			break;
		}
	}
	if(validationError){ 
		alert("ディールは各価格帯から最低2個選択してください！");
		return false;
	}
});

$(document).on('click', '.move-submit', function(){
	var target = $('.submit');
	$(window).scrollTop(target.offset().top);
}).css('cursor','pointer');
