<html>
<head>
	<style>
		table, th, tr, td{
			border: solid 1px #555;
			border-collapse: collapse;
		}
		th{
			background-color: #ada;
		}
		.num_column{
			text-align: right
		}
		.is_selected{
			text-align: center;
		}
	</style>
</head>
<body>
test<br>
<?php
	$user = 'root';
	$passwd = '';
	$deal_id_1 = $_GET['deal_id_1'];
	$deal_id_2 = $_GET['deal_id_2'];

	$sum = 0;

	try{
		$pdo = new PDO( 'mysql:dbname=test;host=localhost', $user, $passwd );
		$sql = 'select * from DEAL_PRICE_TEST';
		print( '<table>' );
		print( '<tr>' );
		print( '<th>DEAL_ID</th>' );
		print( '<th>DEAL_PRICE</th>' );
		print( '<th>is_selected</th>' );
		print( '</tr>' );
		foreach( $pdo->query($sql) as $row ){
			print( '<tr>' );
			print( '<td class="num_column">'.$row['DEAL_ID'].'</td>' );
			print( '<td class="num_column">'.$row['DEAL_PRICE'].'</td>');
			$val = intval($deal_id_1);
			$is_selected = $row['DEAL_ID'] == $deal_id_1 || $row['DEAL_ID'] == $deal_id_2;
			print('<td class="is_selected">'.($is_selected ? ' o ' : '') .'</td>');
			if( $is_selected ){
				$sum += $row['DEAL_PRICE'];
			}
			print( '</tr>' );
		}
		print('</table>');
	}catch( PDOException $e) {
		print( 'Error:'.$e->getMessage() );
		dir();
	}
	print( "SUM :".$sum.'円' );
?>
</body>
</html>