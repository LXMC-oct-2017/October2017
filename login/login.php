<?php
    session_start();
    if( isset($_SESSION['LXMC_TEAM']) ){
        unset($_SESSION['LXMC_TEAM']);
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>LXMC TEAM LOGIN</title>
    <meta name="viewport" content="width=380px">
    <link rel="stylesheet" type="text/css" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
  <div id="header">
    <img src="../img/luxa_header.png" />
  </div>
  <div id="contents">
    <div id="err">
        <?php
            if( isset($_GET['result']) && $_GET['result'] == 'failed' ){
                echo "<p><b>ログインに失敗しました<b></p>";
            }
        ?>
    </div>
    <div id="contents-inner">
      <div id="message"><center>team</center></div>
      <form id="password-form" method="GET" action="./login-auth.php">
        <div id="select">
          <select name="team-id">
            <option value= "0">a</option>
            <option value= "1">b</option>
            <option value= "2">c</option>
            <option value= "3">d</option>
            <option value= "4">e</option>
            <option value= "5">f</option>
            <option value= "6">g</option>
            <option value= "7">h</option>
            <option value= "8">i</option>
            <option value= "9">j</option>
            <option value="10">k</option>
            <option value="11">l</option>
            <option value="12">m</option>
            <option value="13">n</option>
            <option value="14">o</option>
            <option value="15">p</option>
            <option value="16">q</option>
            <option value="17">r</option>
            <option value="18">s</option>
          </select>
        </div>
        <div id="password">
          <center>password</center>
          <input type="password" name="password">
        </div>
        <div id="button">
          <input type="button" name="password-submit" value="ログイン">
        </div>
      </form>
    </div>
  </div>
  <div id="footer">
    <img src="../img/luxa_footer.png" />
  </div>
   <script>
        $('input[name="password-submit"]').click( function(){
            let result = validate();
            if(result.code != ValidatoinResult.SUCCESS){
                $('#err').empty();
                let errMsg = $('<p></p>').attr('id', 'err-msg').appendTo($('#err'));
                errMsg.text(result.msg);
                return false;
            }
            $('#password-form').submit();
        });


        var ValidatoinResult = {
            SUCCESS: true,
            ERROR:false,
        };
        Object.freeze(ValidatoinResult);

        let validate = function(){
            let validateResult = { code:ValidatoinResult.ERROR, msg:''};
            if( $('input[name="password"]').val() == '' ){
                validateResult.msg = 'パスワードを入力してください';
                return validateResult;
            }
            validateResult.code = ValidatoinResult.SUCCESS;
            return validateResult;
        }
    </script>
</body>
</html>
