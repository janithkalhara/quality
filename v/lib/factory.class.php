<?php
class Factory{

	public static function numberFormat($number) {
		return number_format($number,2,'.',',');
	}
	
	public static function getMemcache(){
		$memcache = new Memcache;
		$memcache->connect("localhost",11211);
		return $memcache;
	}

	public static function getHash($string){
		return md5($string);
	}
	
	public static function addToSessionStore($key, $value) {
		$_SESSION['__store'][$key] = $value;
	}
	
	public static function getFromSessionStore($key) {
		return isset($_SESSION['__store'][$key]) ? $_SESSION['__store'][$key] : null; 
	}
	
	public static function clearSessionStore() {
		unset($_SESSION['__store']);
	}
	
	public static function dropFromSessionStore($key) {
		unset($_SESSION['__store'][$key]);
	}
	
	public static function getMongo() {
		$connection = new Mongo('mongodb://'. DB_MONGO_USER .':' .DB_MONGO_PASSWORD. '@' . DB_MONGO_HOST,array('db' => DB_MONGO_NAME,'connect' => true,'connectTimeoutMS' => 2000));
	
		if($connection) {
			$db = $connection->selectDB('scheme');
			if($db) { return $db; }
		}
		else {
			throw new Exception('Unable to connect database.');
		}
	}
	
	public static function show404() {
		ob_start();
		$__page = (object)array(
				'title' => 'Page Not Found -  SPS',
				'sections' => array(APP_ROOT.'/components/views/section_404.php'),
				'assets' => array(
						array('STYLE', APP_ASSET_PATH.'/css/bootstrap.css','HEAD'),
						array('STYLE', APP_ASSET_PATH.'/css/font-awesome.css','HEAD'),
						array('STYLE', APP_ASSET_PATH.'/css/base.css','HEAD'),
						array('SCRIPT', APP_ASSET_PATH.'/js/base.js','HEAD'),
				)
		);
		require_once APP_TEMPLATE_PATH.'/base.php';
		$contents = ob_get_contents();
		ob_end_clean();
		echo $contents;
		exit();
		
	}
}
?>