<?php
class Store {
	protected $_store = array();
	protected $_scripts = array();
	protected $_styles = array();
	
	public function __construct(){
	
	}
	
	public function set($key,$value) {
		$this->_store[$key] = $value;
	}
	
	public function get($key) {
		return $this->_store[$key];
	}
	
	public function pushScript($scriptName) {
		array_push($this->_scripts, $scriptName);
	}
	
	public function getScripts() {
		return (!empty($this->_scripts)) ? $this->_scripts : false;
	}
	
	public function pushStyle($styleName) {
		array_push($this->_styles, $styleName);
	}

	public function getStyles() {
		return (!empty($this->_styles)) ? $this->_styles : false;
	}
}
?>