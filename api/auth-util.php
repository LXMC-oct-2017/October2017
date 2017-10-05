<?php
	require_once dirname(__FILE__).'/config.php';
	class AuthUtil{
		public static function redirectIfNotLoggedIn(){
			session_start();
			if( !isset($_SESSION['LXMC_TEAM']) ){
				$config = Config::getInstance()->getConfig('url');
				$login_url = $config['login_url'];
				header("Location: {$login_url}");
				exit;
			}
		}
		
		public static function forbiddenIfNotAuthorized(){
			session_start();
			if( !isset($_SESSION['LXMC_TEAM']) ){
				http_response_code(403);
				exit;
			}
		}
	}
?>