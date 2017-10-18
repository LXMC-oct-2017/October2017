function footerStart(selector){
      // #itemまでスクロール
    $('html,body').animate({scrollTop: $(selector).offset().top},'fast');
    //スクロールの着地点を生成
}

$("#contents-inner").append("<div id='res'><button id='result'>結果発表</button></div>");

$(document).ready(function(){
  $('.result').hide();
  footerStart("button");
});

$(document).on('click', '#result', function() {
    $("html,body").animate({scrollTop:0},4000);
    return false;
});
