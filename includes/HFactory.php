<?php

class HFactory{
	function getAbsolutePath($path ) {
		$absolutePath=$path;
		$ds=DIRECTORY_SEPARATOR;
		$pos=strripos($absolutePath, '/');
		$absolutePath=substr($absolutePath, 0,$pos+1);
		
		$rootName=substr(BASE_PATH,strrpos(BASE_PATH,DS ));
		$v=strpos($absolutePath,$rootName );
	    $absolutePath=substr($absolutePath,$v+strlen($rootName));
		return $absolutePath;
		

	}
	
	public static function getDb(){
		$db = new HDatabase();
		$db->connect();
		return $db;
	}

}

?>