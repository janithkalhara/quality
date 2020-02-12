<?php 
class Request {
	private $_get = null;
	private $_post = null;
	private $_files = null;
	private $_is_ajax = null;
	private $_uri = null;
	private $_backto = null;
	private $_referrer = null;
	
	
	public function __construct() {
		$this->collect();
		if($this->getParam("hash")) {
			$this->removeHash($this->_post);
		}
	}
	
	public function collect() {
		$this->_get = (object)array_map(array($this,"cleanMore"), $_GET);
		$this->_post = (object)array_map(array($this,"cleanMore"), $_POST);
		$this->_files = (object)$_FILES;
		$this->_is_ajax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest") ? true : false;
		$this->_uri = $_SERVER['REQUEST_URI'];
		$this->_backto = property_exists($this->_get, '__backto') ? urldecode($this->_get->__backto) : null;
		$this->_referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
	}
	
	public  function hasParam($key) {
		return (property_exists($this->_get, $key) || property_exists($this->_post,$key)) ? true : false; 
	}
	
	public  function getParam($key) {
		if(property_exists($this->_get, $key)) { return $this->_get->$key; } 
		else if(property_exists($this->_post,$key)) { return $this->_post->$key; }	
		else { return false; }
	}

	public function getFiles(){
		return $this->_files;
	}
	
	public function getURI() {
		return $this->_uri;
	}
	
	public function isAjax() {
		return $this->_is_ajax;
	}
	
	public function getBackLink() {
		$back_link = $this->_backto;
		$this->_backto = null;
		return $back_link;
	}
	
	public function getReferrer() {
		return $this->_referrer;
	}
	
	public function cleanMore($value){
			$value = is_array($value) ? array_map(array($this,'cleanMore'),$value) : $this->clean($value);
			return $value;
	}
	
	public function clean($value) {
		//$value = filter_var($value,FILTER_SANITIZE_URL);
		//$value = @strip_tags($value);
		//$value = @stripslashes($value);
		return $value;
	}
	
	public function removeHash($value) {
		$hash = $this->getParam("hash");
		foreach ($value as $key => $temp) {
			$rets = explode("-", $key);
			$keyHash = array_shift($rets);
			
			if($keyHash == $hash){
				$val = implode("-", $rets);
				unset($value->$key);
				$value->$val = $temp;
			}
		}
		return $value;
	}
	
	public static function getController($url) {
		$urlarray = explode("/", $url);
		$controller = (isset($urlarray[0]) && $urlarray[0]) ? $urlarray[0] : "default";
		array_shift($urlarray);
		$action = (isset($urlarray[0]) && $urlarray[0]) ? $urlarray[0] : "index";
		array_shift($urlarray);
		$controllerName = $controller;
		$controller = ucwords($controller);
		$controller .= "Controller";
		return array('controller' => $controller,'action' => $action);
	}
}
?>