
/**
 * grouping deal by category
 */
var createDealInputForm = function( dealList, attributesProvider ){
	//	create file elements and its root
	var $file0 = $('<div class="file" id="file0"></div>').append($('<div class="file-title" id="file-title0" value="0">価格帯（低）</div>'));
	var $file1 = $('<div class="file" id="file1"></div>').append($('<div class="file-title" id="file-title1" value="1">価格帯（中）</div>'));
	var $file2 = $('<div class="file" id="file2"></div>').append($('<div class="file-title" id="file-title2" value="2">価格帯（高）</div>'));

	// create deals root element
	var $deal = $('<div>').addClass('files').append($file0).append($file1).append($file2);
	$('.message').after($deal);

	
	let categoryDealList = [[], [], []];
	for( let deal of dealList ){
		categoryDealList[deal.dealCategory].push(deal);
	}

	// ディール金額公開ボタン(制御)
	var $form = $('<form action="result.php" method="POST" name="checkbox-group"/>');
	$('.files').wrap($form);
	$('.files').after('<input class="submit" type="submit" value="合計金額公開"/>');

	// separate deals by deal category
	for( let i=0; i<3; ++i ){
		let list = document.createElement('div');
		list.className = 'deals';
		for( categoryDeal of categoryDealList[i] ){
			let attr = attributesProvider();
			attr.value = categoryDeal.dealId;
			let input = $('<input></input>', attr );
			
			var dealTitle = $('<p></p>', {
				"class": "deal-title",
				html: categoryDeal.no + '. ' + categoryDeal.dealTitle
			});
			var divDeal = $('<div>').addClass('deal').append(input).append(dealTitle).wrapInner('<label></label>');
			list.appendChild(divDeal[0])
		}
		$('#file' + i).append(list);
		$('#file' + i).children('.deals').hide();
	}
}
