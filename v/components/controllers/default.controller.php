<?php

class DefaultController extends Controller {
    /**
     * @access private
     */
    public function index() {
    	if(!$this->__sessionUser instanceof User) { header('Location:/index.php?__backto='.urlencode('/v'));exit(); }
    	$template = __DIR__.'/../views/section_home.php';
    	
    	if($this->__sessionUser->isSupplier()) {
    		$template = __DIR__.'/../views/section_supplier.home.php';
    	}
    	$__page = (object)array('title' => 'Quality Analysis System',
    						'sections' => array($template),
    						'assets' => array(
    									array('STYLE', APP_CDN.'/css/select2.css','HEAD'),
										array('STYLE', APP_CDN.'/css/datepicker.css','HEAD'),
										array('STYLE', APP_CDN.'/css/base.css','HEAD'),
										array('SCRIPT', APP_CDN.'/js/bootstrap-datepicker.js','HEAD'),
										array('SCRIPT', APP_CDN.'/js/jquery.validate.js','HEAD'),
										array('SCRIPT', APP_CDN.'/js/jquery.form.js','HEAD'),
    									array('SCRIPT', APP_CDN.'/js/select2.min.js','HEAD'),
										array('SCRIPT', APP_CDN.'/js/base.js','HEAD'),
    							)	
    				
    			);
    	
    	require_once APP_TEMPLATE_PATH.'/base.php';
    }
}
?>
