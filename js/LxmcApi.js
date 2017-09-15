
var LxmcApi = function(url){
	this.url = url;
	this.method = 'GET';
	this.dataType = 'json';
	this.successHandler = function(data){};
	this.errorHandler = this.defailtErrorHandler;
	this.doneHandler = function(data){};
	this.response;
}

LxmcApi.prototype.callApi = function(doneHandler){
	let res = $.ajax({
		type: this.method,
		url: this.url,
		dataType: this.dataType,
		success: this.successHandler,
		error: this.errorHandler,
	}).done(doneHandler);
	return res;
}

LxmcApi.prototype.defeaultErrorHandler = function( data ){
	console.log( data.responseText );
}