<?php
	session_start();
	if( !isset($_SESSION['LXMC_TEAM']) ){
		http_status_code()
	}
	require_once 'database/database.php';
?>