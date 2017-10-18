function footerStart(selector){
      // #itemまでスクロール
    $('html,body').animate({scrollTop: $(selector).offset().top},'fast');
    //スクロールの着地点を生成
}$("#contents-inner").append("<div id='message'>結果発表</div>");

$(document).ready(function(){
  $('.result').hide();
  footerStart("#message");
  $('html,body').animate({scrollTop: 0}, 500, 'slow');
  //$('#message').fadeIn(7000);
  //$('.result').show();
});

function scrollToTop() {
  $('html,body').animate({scrollTop: 0}, 500, 'slow');
}
