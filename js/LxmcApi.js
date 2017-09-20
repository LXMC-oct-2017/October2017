
var LxmcApi = function(){
    this.method = 'GET';
    this.dataType = 'json';
    this.data = null;
    this.successHandler = function(data){};
    this.errorHandler = this.defailtErrorHandler;
    this.doneHandler = function(data){};
}

LxmcApi.prototype.callApi = function(url, doneJsonHandler=function(data){}){
    let res = $.ajax({
        type: this.method,
        url: url,
        dataType: this.dataType,
        data: this.data,
        success: this.successHandler,
        error: this.errorHandler,
    }).done(function(data){
        doneJsonHandler(data);
    });
    return res;
}

LxmcApi.prototype.defeaultErrorHandler = function( data ){
    console.log( data.responseText );
}

LxmcApi.prototype.callGetItemUseHistory = function(doneHandler){
    let res = this.callApi('../api/get-item-use-history.php').done(function(data){
        let itemUseHistoryList = [];
        data.forEach(function(hist){
            let itemUseHistory = new LxmcItemUseHistory(hist.teamId, hist.itemName, hist.dealIdList, hist.itemUseResult );
            itemUseHistoryList.push(itemUseHistory);
        });
        doneHandler(itemUseHistoryList);
    });
    return res;
}

var LxmcItemUseHistory = function(teamId, itemName, dealIdList, useResult){
    this.teamId = teamId;
    this.itemName = itemName;
    this.dealIdList = dealIdList;
    this.useResult = useResult;
}

