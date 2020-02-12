<?php
abstract class Controller {
  
    protected $_models;
    protected $_controller;
    protected $_request;
    protected $__data = null;
    protected $__page = null;
    protected $__sessionUser = null;

    function __construct($action) {
        $this->_action = $action;
        $this->_request = new Request();
        $this->__sessionUser = Auth::getSessionUser();
    }
    
    /**
     * 
     * @return Request
     */
    public function getRequest() {
    	return $this->_request;
    }

    public function getParam($key) {
    	return $this->_request->getParam($key);
    }
    
    public function hasParam($key) {
    	return $this->_request->hasParam($key);
    }
    
    public function isAjax() {
    	return $this->_request->isAjax();
    }
    
    protected function ___renderv2() {
    	if(!is_null($this->__page)) { Template::render($this->__page, 'web'); }
    	
    	if(!is_null($this->__data)) {Template::render($this->__data, 'ajax');}
    }
    public function isAuthorized() {
    	if($this->__sessionUser instanceof User) {
    		return true;
    	} 
    	else {
			throw new Exception('Not authorized.',401);    		
    	}
    }
}
?>