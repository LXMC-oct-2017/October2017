
/**
 * grouping deal by category
 */
var createDealInputForm = function( dealList, attributesProvider ){
	let categoryDealList = [[], [], []];
	for( let deal of dealList ){
		categoryDealList[deal.dealCategory].push(deal);
	}
	
	// separate deals by deal category
	for( let i=0; i<3; ++i ){
		let list = document.createElement('div');
		list.className = 'deals';
		for( categoryDeal of categoryDealList[i] ){
			let attr = attributesProvider();
			attr.value = categoryDeal.dealId;
			let input = $('<input />', attr );
			
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
