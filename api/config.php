<?php
	class Config{
		private $config;
		private function __construct(){
			$this->config = parse_ini_file(dirname(__FILE__).'/../conf/lxmc.ini', true, INI_SCANNER_TYPED);
		}
		
		final public static function getInstance(){
			static $instance;
			return $instance ?: $instance = new self;
		}
		
		final public function __clone(){
			// forbid clone
			throw new Exception('this instance is singleton class');
		}
		
		public function getConfig($section){
			return $this->config[$section];
		}
	}
?>