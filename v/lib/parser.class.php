<?php
class Parser {
	private $_data = null;
	
	public function __construct($string) {
		$this->_data = $this->process($string);
	}
	
	public function process($string) {
		$string = trim(str_replace(array('*','/','\n','\r'), array('','','',''), $string));
		preg_match_all('/@([a-z]+)\s+(.*?)\s*(?=$|@[a-z]+\s)/s', $string, $matches);
		return array_combine($matches[1], $matches[2]);
	}
	
	public function get($key) {
		return isset($this->_data[$key]) ? $this->_data[$key] : null;
	}
	
	public static function parse($string) {
		return new Parser($string);
	}
}
?>