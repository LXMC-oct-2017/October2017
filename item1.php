<html>
<head>
  <meta charset="utf-8">
  <title>lxmc item1</title>
  <meta name="viewport" content="width=380px">
  <link rel="stylesheet" type="text/css" href="css/common.css">
  <link rel="stylesheet" type="text/css" href="css/item1.css">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="js/LxmcApi.js"></script>
</head>
<body>
  <div id="header">
    <img src="img/luxa_header.png" width="100%"/>
  </div>
  <div id="contents-inner">
    <div class="message">
      <p>アイテム1を使用するディールを選択してください</br>
      選択したディールの金額を公開されます
    　</p>
    </div>
      <button class="switch">
        ディール一覧
      </button>
      <button class="submit">ディール金額公開</div>
  </div>
  <div id="footer">
    <img src="img/luxa_footer.png" width="100%"/>
  </div>
</body>
</html>
<script>
$('.switch').click(function() {
  if ($('.deals').length) {
    $(".deals").remove();
  } else {
	  let onSucceeded = function(json) {
        var list = document.createElement('div');
        list.className = 'deals';

        json.forEach(function(val, key) {
          var $checkbox = $('<input></input>', {
            name: "checked",
            type: "checkbox",
            value: json[key].dealId,
          });

          var $dealTitle = $('<p></p>', {
            "class": "deal-title",
            html: json[key].dealTitle
          });

          var $deal = $('<div>').addClass('deal').append($checkbox).wrapInner($dealTitle);

          list.appendChild($deal[0]);
        });
        $('.submit').before(list);
      };
	  
	  let api = new LxmcApi();
	  api.callApi('api/get-deal-all.php', onSucceeded );
  }
});

$('.submit').click(function() {
  deals = $('[name="checked"]:checked').map(function() {
    return $(this).val();
  }).get();

  //TODO 複数選択時のエラーハンドリング
  let api = new LxmcApi();
  api.data = {'dealId': 100000};
  api.errorHandler = function(XMLHttpRequest, textStatus, errorThrown) {
	console.log(XMLHttpRequest.status);
	console.log(textStatus);
	console.log(errorThrown.message);
  }
  api.callApi('api/use-item1.php', function(data){console.log(data);});
});
</script>
