function footerStart(selector){
      // #itemまでスクロール
    $('html,body').animate({scrollTop: $(selector).offset().top},'fast');
    //スクロールの着地点を生成
}

function scrollTopAnimation(time) {
  $("html,body").animate({scrollTop:0},time);
}

$("#contents-inner").append("<div id='res'><button id='result'>結果発表</button></div>");

$(document).ready(function(){
  var rowCount = $('.result').length;
  var rowHeight = $('.result').height();
  //console.log(rowHeight);
  $('#teamResult').css('height', rowCount * rowHeight + 'px');
  footerStart("button");
});

$(document).on('click', '#result', function() {
    $('.result').show();
    scrollTopAnimation(4000);
    return false;
});
