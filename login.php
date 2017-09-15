
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>LXMC TEAM LOGIN</title>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
	<div id="err">
		<?php
			if( isset($_GET['result']) && $_GET['result'] == 'failed' ){
				echo "<p><b>ログインに失敗しました<b></p>";
			}
		?>
	</div>
	<form id="password-form" method="GET" action="login-auth.php">
		<select name="team-id">
			<option value= "0">TEAM 01</option>
			<option value= "1">TEAM 02</option>
			<option value= "2">TEAM 03</option>
			<option value= "3">TEAM 04</option>
			<option value= "4">TEAM 05</option>
			<option value= "5">TEAM 06</option>
			<option value= "6">TEAM 07</option>
			<option value= "7">TEAM 08</option>
			<option value= "8">TEAM 09</option>
			<option value= "9">TEAM 10</option>
			<option value="10">TEAM 11</option>
			<option value="11">TEAM 12</option>
			<option value="12">TEAM 13</option>
			<option value="13">TEAM 14</option>
			<option value="14">TEAM 15</option>
			<option value="15">TEAM 16</option>
			<option value="16">TEAM 17</option>
			<option value="17">TEAM 18</option>
			<option value="18">TEAM 19</option>
			<option value="19">TEAM 20</option>
		</select>
		<input type="password" name="password">
		<input type="button" name="password-submit" value="Send">
	</form>
	<script>
		$('input[name="password-submit"]').click( function(){
			console.log('test');
			let result = validate();
			if(result.code != ValidatoinResult.SUCCESS){
				console.log("error");
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